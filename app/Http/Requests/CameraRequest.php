<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CameraRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:191',
            'description' => 'required',
            'longitude' => 'nullable|between:-180,180',
            'latitude' => 'nullable|between:-90,90',
            'developer_id' => 'required|exists:developers,id',
            'project_id' => 'required|exists:projects,id',
            'is_active' => 'nullable|boolean',
            'video_template_1' => 'nullable|string',
            'video_template_2' => 'nullable|string',
            'timezone' => 'required|in:Asia/Dubai,Asia/Riyadh',
        ];
    }
}
