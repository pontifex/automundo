<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Query\Builder;

/**
 * @property string $id
 * @property string $name
 * @property string $slug
 * @property string $brand_id
 *
 * @method static void save()
 * @method static Builder where(string $fieldName, mixed $fieldValue)
 * @method static Model find(string $id)
 * @method static Builder offset(int $offset)
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
