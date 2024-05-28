<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Query\Builder;

/**
 * @psalm-property string $id
 * @psalm-property string $name
 * @psalm-property string $slug
 * @psalm-property string $brand_id
 *
 * @method static bool save(array $options = [])
 * @method static Builder where(string $fieldName, mixed $fieldValue)
 * @method static Model|null find(string $id)
 * @method static Builder offset(int $offset)
 *
 * @psalm-suppress PropertyNotSetInConstructor
 */
class Model extends EloquentModel
{
    use HasFactory;

    protected $keyType = 'string';

    protected $fillable = [
        'name',
        'slug',
    ];

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }
}
