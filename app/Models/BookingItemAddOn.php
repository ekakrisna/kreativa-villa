<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BookingItemAddOn
 * 
 * @property int $id
 * @property int $booking_item_id
 * @property int $add_on_id
 * @property int $qty
 * @property float $unit_price
 * @property float $line_total
 * @property array|null $meta_snapshot
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property AddOn $add_on
 * @property BookingItem $booking_item
 *
 * @package App\Models
 */
class BookingItemAddOn extends Model
{
	protected $table = 'booking_item_add_ons';

	protected $casts = [
		'booking_item_id' => 'int',
		'add_on_id' => 'int',
		'qty' => 'int',
		'unit_price' => 'float',
		'line_total' => 'float',
		'meta_snapshot' => 'json'
	];

	protected $fillable = [
		'booking_item_id',
		'add_on_id',
		'qty',
		'unit_price',
		'line_total',
		'meta_snapshot'
	];

	public function add_on()
	{
		return $this->belongsTo(AddOn::class);
	}

	public function booking_item()
	{
		return $this->belongsTo(BookingItem::class);
	}
}
