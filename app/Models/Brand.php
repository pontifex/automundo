<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Query\Builder;

/**
 * @property string $id
 * @property string $name
 * @property string $slug
 *
 * @method static void save()
 * @method static Builder where(string $fieldName, mixed $fieldValue)
 * @method static Brand find(string $id)
 * @method static Builder offset(int $offset)
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
