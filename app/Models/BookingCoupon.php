<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BookingCoupon
 * 
 * @property int $id
 * @property int $booking_id
 * @property int $coupon_id
 * @property float $discount_amount
 * @property array|null $meta_snapshot
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Booking $booking
 * @property Coupon $coupon
 *
 * @package App\Models
 */
class BookingCoupon extends Model
{
	protected $table = 'booking_coupons';

	protected $casts = [
		'booking_id' => 'int',
		'coupon_id' => 'int',
		'discount_amount' => 'float',
		'meta_snapshot' => 'json'
	];

	protected $fillable = [
		'booking_id',
		'coupon_id',
		'discount_amount',
		'meta_snapshot'
	];

	public function booking()
	{
		return $this->belongsTo(Booking::class);
	}

	public function coupon()
	{
		return $this->belongsTo(Coupon::class);
	}
}
