<?php


namespace App\Http\Controllers;

use App\Traits\FileHelper;
use function request;
use function response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class FileUploadController extends Controller
{
    use FileHelper;

    public function storeGallery(Request $request): string
    {
        return $this->saveTempImageAndGetName(
            $request->file('test')
        );
    }

    public function removeGallery()
    {
        $this->deleteFile(request()->get('file'));
    }

    public function fetchGallery(Request $request)
    {
        $name = $request->get('load');

        if (!Storage::exists($name)) {
            return response()->make('File no found.', 404);
        }

        $file = Storage::get($name);
        $type = Storage::mimeType($name);
        return response()->make($file, 200)->header("Content-Type", $type);
    }

    public function downloadImage(Request $request)
    {
        $request->validate(['upload_url' => 'required|url']);

        if(!getimagesize($request->upload_url)){
            throw ValidationException::withMessages(['upload_url' => 'No image found on the given url']);
        }

        $response = Http::get($request->upload_url);

        if($response->successful()){

            $content = $response->body();

            $imageName = time() . Str::random(30) . '.' . 'png';

            $finalDestination = 'Temps/'.$imageName;

            Storage::put($finalDestination,$content);
            
            return response()->json($this->getImageByName($finalDestination));
        }

        return response()->json(['error' => 'Something went wrong'],500);
    }
}
