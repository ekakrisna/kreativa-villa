<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SeasonalPricing
 * 
 * @property int $id
 * @property int $product_id
 * @property Carbon $start_date
 * @property Carbon $end_date
 * @property float $rate
 * @property string $rate_unit
 * @property int|null $min_nights
 * @property int|null $min_days
 * @property int|null $day_of_week_mask
 * @property string|null $name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Product $product
 *
 * @package App\Models
 */
class SeasonalPricing extends Model
{
	protected $table = 'seasonal_pricing';

	protected $casts = [
		'product_id' => 'int',
		'start_date' => 'datetime',
		'end_date' => 'datetime',
		'rate' => 'float',
		'min_nights' => 'int',
		'min_days' => 'int',
		'day_of_week_mask' => 'int'
	];

	protected $fillable = [
		'product_id',
		'start_date',
		'end_date',
		'rate',
		'rate_unit',
		'min_nights',
		'min_days',
		'day_of_week_mask',
		'name'
	];

	public function product()
	{
		return $this->belongsTo(Product::class);
	}
}
