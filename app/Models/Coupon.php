<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Coupon
 * 
 * @property int $id
 * @property string $code
 * @property string $type
 * @property float $value
 * @property string $applies_to
 * @property Carbon|null $valid_start
 * @property Carbon|null $valid_end
 * @property int|null $usage_limit
 * @property int $usage_count
 * @property float|null $min_subtotal
 * @property string $status
 * @property array|null $meta
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|Booking[] $bookings
 *
 * @package App\Models
 */
class Coupon extends Model
{
	protected $table = 'coupons';

	protected $casts = [
		'value' => 'float',
		'valid_start' => 'datetime',
		'valid_end' => 'datetime',
		'usage_limit' => 'int',
		'usage_count' => 'int',
		'min_subtotal' => 'float',
		'meta' => 'json'
	];

	protected $fillable = [
		'code',
		'type',
		'value',
		'applies_to',
		'valid_start',
		'valid_end',
		'usage_limit',
		'usage_count',
		'min_subtotal',
		'status',
		'meta'
	];

	public function bookings()
	{
		return $this->belongsToMany(Booking::class, 'booking_coupons')
					->withPivot('id', 'discount_amount', 'meta_snapshot')
					->withTimestamps();
	}
}
