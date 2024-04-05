<?php

namespace App\Jobs;

use App\Models\Video;
use App\Traits\FileHelper;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\Process\Process;

class CreateTimelapseVideo implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, FileHelper;

    /**
     * Create a new job instance.
     */
    public function __construct(protected Video $video, protected array $photos)
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $tempDirName = time();
        $tempDirPath = $this->createTempDirectory($tempDirName);

        $photoListFilePath = $this->copyAndRenamePhotos($tempDirPath, $this->photos);

        $outputPath = $this->generateOutputPath();

        $ffmpegCommand = $this->constructFFmpegCommand($photoListFilePath, $outputPath);

        $process = new Process($ffmpegCommand);
        $process->run();

        if ($process->isSuccessful()) {
            $this->video->update([
                'file' => $outputPath,
                'generated_at' => now(),
                'status' => 'completed',
            ]);
        } else {
            $this->video->update([
                'status' => 'failed',
            ]);
            Log::error($process->getErrorOutput());
        }

        Storage::deleteDirectory($tempDirPath);
    }

    protected function createTempDirectory($tempDirName)
    {
        $tempDirPath = storage_path("app/public/Temps/{$tempDirName}");
        Storage::makeDirectory($tempDirPath);
        return "Temps/{$tempDirName}";
    }

    protected function copyAndRenamePhotos($tempDirPath, $photos)
    {
        $photoList = [];

        foreach ($photos as $index => $photo) {
            $extension = pathinfo($photo['image'], PATHINFO_EXTENSION);
            $destinationPath = "{$tempDirPath}/" . str_pad($index + 1, 6, '0', STR_PAD_LEFT) . ".$extension";
            Storage::copy($photo['image'], $destinationPath);
            $photoList[] = "file '" . Str::replace('/', DIRECTORY_SEPARATOR, Storage::path($destinationPath)) . "'";
        }

        $photoListFilePath = "{$tempDirPath}/photo_list.txt";
        Storage::put($photoListFilePath, implode(PHP_EOL, $photoList));

        return $photoListFilePath;
    }

    protected function generateOutputPath()
    {
        $folder = $this->getFolderName(Video::class);
        return "{$folder}/" . time() . Str::random(30) . '.mp4';
    }

    protected function constructFFmpegCommand($photoListFilePath, $outputPath)
    {
        return [
            'ffmpeg',
            '-f', 'concat',
            '-r', '5',
            '-safe', '0',
            '-i', Str::replace('/', DIRECTORY_SEPARATOR, Storage::path($photoListFilePath)),
            '-framerate', '5',
            '-s:v', '1440x1080',
            '-c:v', 'libx264',
            '-crf', '17',
            '-pix_fmt', 'yuv420p',
            Str::replace('/', DIRECTORY_SEPARATOR, Storage::path($outputPath))
        ];
    }
}
