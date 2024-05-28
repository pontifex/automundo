<?php

namespace App\Http\Requests;

use App\Rules\UniqueBrand;
use App\Serializers\BrandSerializer;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @psalm-suppress PropertyNotSetInConstructor
 */
class AddBrand extends FormRequest
{
    /**
     * @psalm-api
     * @psalm-param string|resource|null $content
     */
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

    /**
     * @psalm-api
     */
    public function rules(): array
    {
        return [
            sprintf('%s.name', BrandSerializer::getType()) => [
                'required',
                'string',
                $this->uniqueBrand,
            ],
        ];
    }
}
