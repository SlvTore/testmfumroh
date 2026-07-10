<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreSubscriberRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {

        $nama = $this->input('nama', '');
        $email = $this->input('email', '');
        $noHp = $this->input('no_hp', '');


        $cleanedNama = ucwords(strtolower(trim($nama)));
        $cleanedEmail = strtolower(trim($email));
        $cleanedNoHp = preg_replace('/[^0-9+\-\s]/', '', trim($noHp));

   
        $this->merge([
            'nama' => $cleanedNama,
            'email' => $cleanedEmail,
            'no_hp' => $cleanedNoHp,
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nama' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:pesertas,email'],
            'no_hp' => ['required', 'string', 'max:20'],
        ];
    }

    /**
     * Get custom messages for validation errors.
     */
    public function messages(): array
    {
        return [
            'nama.required' => 'Nama wajib diisi',
            'nama.string' => 'Nama harus berupa teks',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'no_hp.required' => 'Nomor telepon wajib diisi',
        ];
    }
}
