<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreServiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        // pastikan user login
        return auth()->check();
    }

    /**
     * Isi resident_id dari user login SEBELUM rules dievaluasi.
     */
    protected function prepareForValidation(): void
    {
        $residentId = auth()->user()?->resident?->id;

        if ($residentId) {
            // inject ke input agar lolos rules 'required|exists'
            $this->merge(['resident_id' => $residentId]);
        }
    }

    public function rules(): array
    {
        return [
            // tetap required, tapi sudah otomatis di-merge di atas
            'resident_id'         => ['required', 'exists:residents,id'],
            'service_category_id' => ['required', 'exists:service_categories,id'],
            'title'               => ['required', 'string', 'max:255'],
            'description'         => ['nullable', 'string'],
            'image'               => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:10240'],
        ];
    }

    public function messages(): array
    {
        return [
            'resident_id.required' => 'Akun Anda belum terhubung dengan data resident.',
            'resident_id.exists'   => 'Data resident tidak ditemukan.',
        ];
    }
}
