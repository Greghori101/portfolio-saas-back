<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePortfolioRequest extends FormRequest
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
            'user_id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'role' => 'nullable|string|max:255',
            'specialty' => 'nullable|string|max:255',
            'bio' => 'nullable|string',
            'description' => 'nullable|string',
            'settings' => 'nullable|array',
            'is_active' => 'boolean',
            'domain' => 'nullable|string|unique:portfolios,domain',
            'domain_type' => 'nullable|in:subdomain,custom',
            'theme_id' => 'nullable|exists:themes,id',
        ];
    }
}
