<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MenuRequest extends FormRequest
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
        $menuId = $this->route('menu');
        $isUpdate = $this->isMethod('PUT') || $this->isMethod('PATCH');
        
        $rules = [
            'name' => $isUpdate ? ['sometimes', 'required', 'string', 'max:255'] : ['required', 'string', 'max:255'],
            'icon' => ['nullable', 'string', 'max:255'],
            'url' => ['nullable', 'string', 'max:255'],
            'parent_id' => ['nullable', 'exists:menus,id'],
            'order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
            'roles' => ['nullable', 'array'],
            'roles.*' => ['string', 'in:super_admin,admin,user,guest'],
        ];

        // Handle slug validation differently for create and update
        if ($isUpdate && $menuId) {
            $rules['slug'] = ['sometimes', 'required', 'string', 'max:255', Rule::unique('menus', 'slug')->ignore($menuId)];
        } else {
            $rules['slug'] = ['required', 'string', 'max:255', 'unique:menus,slug'];
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
            'name.required' => 'Nama menu harus diisi',
            'slug.required' => 'Slug harus diisi',
            'slug.unique' => 'Slug sudah digunakan',
            'parent_id.exists' => 'Parent menu tidak ditemukan',
            'roles.*.in' => 'Role harus salah satu dari: super_admin, admin, user, guest',
        ];
    }
}
