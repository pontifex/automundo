<?php

namespace App\Http\Requests;

use App\Rules\UniqueBrand;
use App\Serializers\BrandSerializer;
use Illuminate\Foundation\Http\FormRequest;

class AddBrand extends FormRequest
{
    public function __construct(
        private readonly UniqueBrand $uniqueBrand,
        array $query = [],
        array $request = [],
        array $attributes = [],
        array $cookies = [],
        array $files = [],
        array $server = [],
        $content = null
    ) {
        parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);
    }

    public function rules(): array
    {
        return [
            sprintf('%s.name', BrandSerializer::getType()) => [
                'required',
                'string',
                $this->uniqueBrand
            ],
        ];
    }
}
