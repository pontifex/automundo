<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Query\Builder;

/**
 * @psalm-property string $id
 * @psalm-property string $name
 * @psalm-property string $slug
 *
 * @method static bool save(array $options=[])
 * @method static Builder where(string $fieldName, mixed $fieldValue)
 * @method static Brand|null find(string $id)
 * @method static Builder offset(int $offset)
 *
 * @psalm-suppress PropertyNotSetInConstructor
 */
class Brand extends EloquentModel
{
    use HasFactory;

    protected $keyType = 'string';

    protected $fillable = [
        'name',
        'slug',
    ];

    public function models(): HasMany
    {
        return $this->hasMany(Model::class);
    }
}
