<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Enums\Roles;
use App\Models\Developer;
use App\Models\Project;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\ValidationException;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = auth()->user();

        return in_array($user->role, ['super_admin', 'admin']) || $user->can_create_users;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'first_name' => 'required|string|max:191',
            'last_name' => 'required|string|max:191',
            'password'  => 'required|string|min:8|max:191|confirmed',
            'email' => 'required|email|unique:users,email',
            'role' => ['required', new Enum(Roles::class)],
            'developers' => 'nullable|array',
            'projects' => 'nullable|array',
            'is_active' => 'boolean',
            'can_create_user' => 'boolean',
            'can_create_video' => 'boolean',
        ];

        if ($this->method() === 'PUT') {
            $rules['password'] = 'nullable|string|min:8|max:191|confirmed';
            $rules['email'] = 'required|email|unique:users,email,' . $this->user->id;
        }

        return $rules;
    }

    public function passedValidation()
    {

        if (count($this->developers) <= 0 && count($this->projects) <= 0) return false;

        $isDevelopersMatched = Developer::whereIn('id', $this->developers)->count() === count($this->developers);

        if (!$isDevelopersMatched) {
            throw ValidationException::withMessages([
                'developers' => 'The developers contains invalid entries'
            ]);
        }

        $isProjectsMatched = Project::whereIn('id', $this->projects)->count() === count($this->projects);

        if (!$isProjectsMatched) {
            throw ValidationException::withMessages([
                'projects' => 'The projects contains invalid entries'
            ]);
        }
    }

    public function validated($a = null, $b = null)
    {
        $validated = parent::validated();

        if (filled($this->password)) {
            $validated['password'] = bcrypt($validated['password']);
        }

        return $validated;
    }
}
