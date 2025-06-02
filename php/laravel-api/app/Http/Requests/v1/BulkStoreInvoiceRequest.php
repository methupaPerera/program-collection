<?php

namespace App\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BulkStoreInvoiceRequest extends FormRequest
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
            "*.customer_id" => ["required", "exists:customers,id"],
            "*.amount" => ["required", "numeric"],
            "*.status" => ["required", Rule::in(["P", "B", "V", "p", "b", "v"])],
            "*.billed_date" => ["required", "date_format:Y-m-d H:i:s"],
            "*.paid_date" => ["nullable", "date_format:Y-m-d H:i:s", "after_or_equal:*.billed_date"],
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            "billed_date" => $this->billedDate,
            "paid_date" => $this->paidDate,
        ]);
    }
}
