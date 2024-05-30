<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Query\Builder;

/**
 * @psalm-property string $id
 * @psalm-property string $description
 * @psalm-property int $mileageDistance
 * @psalm-property string $mileageUnit
 * @psalm-property int $priceAmount
 * @psalm-property string $priceCurrency
 * @psalm-property string $model_id
 *
 * @method static bool save(array $options=[])
 * @method static Builder where(string $fieldName, mixed $fieldValue)
 * @method static Product|null find(string $id)
 * @method static Builder offset(int $offset)
 *
 * @psalm-suppress PropertyNotSetInConstructor
 */
class Product extends EloquentModel
{
    use HasFactory;

    protected $keyType = 'string';

    protected $fillable = [
        'description',
        'mileageDistance',
        'mileageUnit',
        'priceAmount',
        'priceCurrency',
    ];

    public function model(): BelongsTo
    {
        return $this->belongsTo(Model::class);
    }
}
