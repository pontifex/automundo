<?php

namespace App\Http\Requests;

use App\Rules\ExistingBrand;
use App\Rules\UniqueModel;
use App\Serializers\ModelSerializer;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @psalm-suppress PropertyNotSetInConstructor
 */
class AddModel extends FormRequest
{
    /**
     * @psalm-api
     * @psalm-param string|resource|null $content
     */
    public function __construct(
        private readonly ExistingBrand $existingBrand,
        private readonly UniqueModel $uniqueModel,
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
            sprintf('%s.brand_id', ModelSerializer::getType()) => [
                'required',
                'string',
                $this->existingBrand,
            ],
            sprintf('%s.name', ModelSerializer::getType()) => [
                'required',
                'string',
                $this->uniqueModel,
            ],
        ];
    }
}
