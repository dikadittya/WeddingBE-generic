<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
        $userId = $this->route('user');
        $isUpdate = $this->isMethod('PUT') || $this->isMethod('PATCH');
        
        $rules = [
            'name' => $isUpdate ? ['sometimes', 'required', 'string', 'max:255'] : ['required', 'string', 'max:255'],
            'role' => ['nullable', 'string', 'in:admin,user,guest'],
        ];

        // Handle email validation differently for create and update
        if ($isUpdate && $userId) {
            $rules['email'] = ['sometimes', 'required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($userId)];
            $rules['password'] = ['sometimes', 'nullable', 'string', Password::min(8)];
        } else {
            $rules['email'] = ['required', 'string', 'email', 'max:255', 'unique:users,email'];
            $rules['password'] = ['required', 'string', Password::min(8)];
        }

        return $rules;
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Nama harus diisi',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'password.required' => 'Password harus diisi',
            'password.min' => 'Password minimal 8 karakter',
            'role.in' => 'Role harus salah satu dari: admin, user, guest',
        ];
    }
}
