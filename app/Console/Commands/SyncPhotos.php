<?php

namespace App\Console\Commands;

use App\Models\Camera;
use App\Models\Photo;
use Illuminate\Console\Command;

class SyncPhotos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:photos';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync photos to cameras';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $cameras = Camera::where('is_active', true)->get();

        foreach($cameras as $camera) {
            
            $time = now()->format('H:i');
            $text = "{$camera->name} {$time}";
            $url = "https://dummyimage.com/16:9x1080/CCC/000&text={$text}";

            $camera->photos()->create([
                'image' => $camera->downloadImage($url, Photo::class)
            ]);
        }
    }
}
