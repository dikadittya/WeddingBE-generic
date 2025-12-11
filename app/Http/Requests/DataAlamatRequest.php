<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DataAlamatRequest extends FormRequest
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
        $isUpdate = $this->isMethod('PUT') || $this->isMethod('PATCH');
        
        return [
            'kode_alamat' => $isUpdate ? ['sometimes', 'required', 'string', 'max:50'] : ['required', 'string', 'max:50', 'unique:data_alamat,kode_alamat'],
            'nama_provinsi' => ['required', 'string', 'max:100'],
            'kode_provinsi' => ['required', 'string', 'max:10'],
            'nama_kabupaten' => ['required', 'string', 'max:100'],
            'kode_kabupaten' => ['required', 'string', 'max:10'],
            'nama_kecamatan' => ['required', 'string', 'max:100'],
            'kode_kecamatan' => ['required', 'string', 'max:10'],
            'nama_desa' => ['required', 'string', 'max:100'],
            'kode_desa' => ['required', 'string', 'max:10'],
            'jarak' => ['nullable', 'numeric', 'min:0', 'max:999999.99'],
            'kd_rumahan' => ['nullable', 'string', 'max:50'],
            'kd_gedung' => ['nullable', 'string', 'max:50'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'kode_alamat.required' => 'Kode alamat harus diisi',
            'kode_alamat.unique' => 'Kode alamat sudah digunakan',
            'nama_provinsi.required' => 'Nama provinsi harus diisi',
            'kode_provinsi.required' => 'Kode provinsi harus diisi',
            'nama_kabupaten.required' => 'Nama kabupaten harus diisi',
            'kode_kabupaten.required' => 'Kode kabupaten harus diisi',
            'nama_kecamatan.required' => 'Nama kecamatan harus diisi',
            'kode_kecamatan.required' => 'Kode kecamatan harus diisi',
            'nama_desa.required' => 'Nama desa harus diisi',
            'kode_desa.required' => 'Kode desa harus diisi',
            'jarak.numeric' => 'Jarak harus berupa angka',
            'jarak.min' => 'Jarak tidak boleh negatif',
            'jarak.max' => 'Jarak maksimal 999999.99 km',
        ];
    }
}
