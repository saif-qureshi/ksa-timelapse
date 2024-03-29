<?php

namespace App\Jobs;

use App\Models\Photo;
use App\Models\Video;
use App\Traits\FileHelper;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\Process\Process;

class CreateTimelapseVideo implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, FileHelper;

    /**
     * Create a new job instance.
     */
    public function __construct(protected $camera, protected $start, protected $end)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $photos = $this->camera
            ->photos()
            ->select('image')
            ->whereBetween('created_at', [$this->start, $this->end])
            ->latest()
            ->limit(10)
            ->get()
            ->map(fn ($item) => Str::replace('/', DIRECTORY_SEPARATOR, Storage::path($item->image)))
            ->toArray();

        $folder = $this->getFolderName(Video::class);
        $videoName = time() . Str::random(30) . '.mp4';
        $outputPath = "{$folder}/{$videoName}";

        $ffmpegCommand = [
            'ffmpeg',
            // '-framerate',
            // '30',
        ];

        foreach ($photos as $photo) {
            $ffmpegCommand[] = '-i';
            $ffmpegCommand[] = $photo;
        }

        $ffmpegCommand[] = '-pix_fmt';
        $ffmpegCommand[] = 'yuv420p';

        $ffmpegCommand = array_merge($ffmpegCommand, [
            '-c:v', 'libx264',
            // '-r', '30',
            '-crf', '17',
            Str::replace('/', DIRECTORY_SEPARATOR, Storage::path($outputPath))
        ]);

        // Execute FFmpeg command
        $process = new Process($ffmpegCommand);
        $process->run();
        // dd($process);
        if ($process->isSuccessful()) {
            dd($outputPath);
        } else {
            dd($process->getErrorOutput(), $process->getExitCodeText());
        }
    }
}
