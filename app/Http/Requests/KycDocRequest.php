<?php

namespace App\Http\Requests;

use App\Enums\Documents;
use App\Helpers\FileHelper;
use App\Models\KycDoc;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class KycDocRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'file' => 'required|file|max:5000|mimes:jpg,jpeg,pdf,png,doc,docx',
            'type' => ['required', Rule::in(Documents::values())]
        ];
    }

    public function fulfilled(): array
    {
        $path = FileHelper::processFileUpload($this->file('file'));

        return array_merge($this->only('name', 'type'), ['path' => $path]);
    }
}
