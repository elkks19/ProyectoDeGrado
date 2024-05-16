<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UpdateUserRequest extends FormRequest
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
            'name' => 'string|max:255',
            'email' => 'string|email|max:255|unique:'.User::class.',email,'.$this->id,
            'ci' => 'numeric|unique:'.User::class.',ci,'.$this->id,
            'fechaNacimiento' => 'date|before:today',
            'password' => 'string|max:255',
            'roles' => 'array',
        ];
    }

    public function update(User $user): User
    {
        if ($this->password) {
            $user->update(['password' => Hash::make($this->password)]);
        }

        $user->update([
            'name' => $this->name,
            'email' => $this->email,
            'ci' => $this->ci,
            'fechaNacimiento' => $this->fechaNacimiento,
        ]);


        $user->syncRoles($this->roles);

        $user->save();

        return $user;
    }
}
