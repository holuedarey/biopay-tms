<?php

namespace App\Http\Requests;

use App\Rules\UserIsAgent;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TerminalRequest extends FormRequest
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
        return $this->routeIs('terminals.store')
            ? $this->createRequest() : $this->updateRequest();
    }

    private function createRequest(): array
    {
        return [
            'email'         => ['required', 'email', new UserIsAgent()],
//            'tid'           => 'required|size:8|unique:terminals,tid',
            'mid'           => 'required|size:15',
            'serial'        => 'required|max:24|unique:terminals,serial',
            'group_id'      => 'required|exists:terminal_groups,id',
            'device'        => 'required|string'
        ];
    }

    private function updateRequest()
    {
        return [
            'group_id'      => 'required|exists:terminal_groups,id',
            'tid'           => ['nullable','size:8', Rule::unique('terminals', 'tid')->ignore($this->terminal)],
            'mid'           => 'nullable|size:15',
            'serial'        => ['nullable','max:24', Rule::unique('terminals', 'serial')->ignore($this->terminal)],
            'device'        => 'nullable|string'
        ];
    }
}
