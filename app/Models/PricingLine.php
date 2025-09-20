<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PricingLine
 * 
 * @property int $id
 * @property int $booking_id
 * @property int|null $booking_item_id
 * @property string $code
 * @property string|null $description
 * @property float $qty
 * @property float $unit_price
 * @property float $amount
 * @property array|null $meta
 * @property int $sort_order
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Booking $booking
 * @property BookingItem|null $booking_item
 *
 * @package App\Models
 */
class PricingLine extends Model
{
	protected $table = 'pricing_lines';

	protected $casts = [
		'booking_id' => 'int',
		'booking_item_id' => 'int',
		'qty' => 'float',
		'unit_price' => 'float',
		'amount' => 'float',
		'meta' => 'json',
		'sort_order' => 'int'
	];

	protected $fillable = [
		'booking_id',
		'booking_item_id',
		'code',
		'description',
		'qty',
		'unit_price',
		'amount',
		'meta',
		'sort_order'
	];

	public function booking()
	{
		return $this->belongsTo(Booking::class);
	}

	public function booking_item()
	{
		return $this->belongsTo(BookingItem::class);
	}
}
