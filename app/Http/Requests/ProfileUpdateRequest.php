<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Persiapkan data sebelum divalidasi agar IPK dengan format koma dapat diterima.
     */
    protected function prepareForValidation(): void
    {
        if ($this->has('ipk')) {
            $this->merge([
                'ipk' => str_replace(',', '.', (string) $this->input('ipk')),
            ]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $tahunSekarang = (int) now()->format('Y') + 1;

        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
            'nim' => ['nullable', 'string', 'max:20'],
            'angkatan' => ['nullable', 'integer', 'min:2000', 'max:' . $tahunSekarang],
            'ipk' => ['nullable', 'numeric', 'min:0', 'max:4'],
            'prestasi_akademik' => ['nullable', 'string'],
            'prestasi_non_akademik' => ['nullable', 'string'],
            'pengalaman_si' => ['nullable', 'string'],
        ];
    }
}
