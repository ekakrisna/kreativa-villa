<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Booking
 * 
 * @property int $id
 * @property int $user_id
 * @property string $code
 * @property string $status
 * @property string $channel
 * @property string $currency
 * @property float $subtotal
 * @property float $discount_total
 * @property float $tax_total
 * @property float $grand_total
 * @property float $paid_total
 * @property float $due_total
 * @property string|null $notes
 * @property array|null $metadata
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * 
 * @property User $user
 * @property Collection|Coupon[] $coupons
 * @property Collection|BookingItem[] $booking_items
 * @property Collection|Payment[] $payments
 * @property Collection|PricingLine[] $pricing_lines
 * @property Collection|Review[] $reviews
 *
 * @package App\Models
 */
class Booking extends Model
{
	use SoftDeletes;
	protected $table = 'bookings';

	protected $casts = [
		'user_id' => 'int',
		'subtotal' => 'float',
		'discount_total' => 'float',
		'tax_total' => 'float',
		'grand_total' => 'float',
		'paid_total' => 'float',
		'due_total' => 'float',
		'metadata' => 'json'
	];

	protected $fillable = [
		'user_id',
		'code',
		'status',
		'channel',
		'currency',
		'subtotal',
		'discount_total',
		'tax_total',
		'grand_total',
		'paid_total',
		'due_total',
		'notes',
		'metadata'
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function coupons()
	{
		return $this->belongsToMany(Coupon::class, 'booking_coupons')
					->withPivot('id', 'discount_amount', 'meta_snapshot')
					->withTimestamps();
	}

	public function booking_items()
	{
		return $this->hasMany(BookingItem::class);
	}

	public function payments()
	{
		return $this->hasMany(Payment::class);
	}

	public function pricing_lines()
	{
		return $this->hasMany(PricingLine::class);
	}

	public function reviews()
	{
		return $this->hasMany(Review::class);
	}
}
