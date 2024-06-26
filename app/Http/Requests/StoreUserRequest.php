<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\User;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Hash;

class StoreUserRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:'.User::class,
            'fechaNacimiento' => 'required|date',
            'ci' => 'required|numeric|unique:'.User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'roles' => 'required|array',
        ];
    }

    public function save(): User
    {
        $user = User::create($this->validated());

        foreach ($this->roles as $role) {
            $user->assignRole($role);
        }

        return $user;
    }
}
