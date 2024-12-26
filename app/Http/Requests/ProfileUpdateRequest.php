<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true; // Mengizinkan pengguna untuk memperbarui profil mereka sendiri
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255', // Nama harus diisi dan maksimal 255 karakter
            'email' => 'required|email|max:255|unique:users,email,' . $this->user()->id, // Email harus unik, kecuali untuk pengguna yang sedang login
        ];
    }
}
