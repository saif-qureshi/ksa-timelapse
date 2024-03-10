<?php

namespace App\Http\Requests\Api;

use App\Models\Camera;
use Illuminate\Foundation\Http\FormRequest;

class PhotoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->validateToken();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'image' => 'required|image|max:20480'
        ];
    }

    public function wantsJson()
    {
        return true;
    }

    public function validateToken()
    {

        $token = request()->header('X-Cam-Auth');
        
        $camera = Camera::where('access_token',$token)->first();
        
        if(!$camera) return false;

        return true;
    }
}
