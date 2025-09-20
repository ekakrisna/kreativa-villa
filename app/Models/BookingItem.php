<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BookingItem
 * 
 * @property int $id
 * @property int $booking_id
 * @property int $product_id
 * @property int|null $product_unit_id
 * @property string|null $title_snapshot
 * @property array|null $meta_snapshot
 * @property int $quantity
 * @property Carbon|null $start_datetime
 * @property Carbon|null $end_datetime
 * @property string $rate_unit
 * @property float $base_rate
 * @property float $line_subtotal
 * @property float $line_discount
 * @property float $line_tax
 * @property float $line_total
 * @property string $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Booking $booking
 * @property Product $product
 * @property ProductUnit|null $product_unit
 * @property Collection|AddOn[] $add_ons
 * @property Collection|PricingLine[] $pricing_lines
 *
 * @package App\Models
 */
class BookingItem extends Model
{
	protected $table = 'booking_items';

	protected $casts = [
		'booking_id' => 'int',
		'product_id' => 'int',
		'product_unit_id' => 'int',
		'meta_snapshot' => 'json',
		'quantity' => 'int',
		'start_datetime' => 'datetime',
		'end_datetime' => 'datetime',
		'base_rate' => 'float',
		'line_subtotal' => 'float',
		'line_discount' => 'float',
		'line_tax' => 'float',
		'line_total' => 'float'
	];

	protected $fillable = [
		'booking_id',
		'product_id',
		'product_unit_id',
		'title_snapshot',
		'meta_snapshot',
		'quantity',
		'start_datetime',
		'end_datetime',
		'rate_unit',
		'base_rate',
		'line_subtotal',
		'line_discount',
		'line_tax',
		'line_total',
		'status'
	];

	public function booking()
	{
		return $this->belongsTo(Booking::class);
	}

	public function product()
	{
		return $this->belongsTo(Product::class);
	}

	public function product_unit()
	{
		return $this->belongsTo(ProductUnit::class);
	}

	public function add_ons()
	{
		return $this->belongsToMany(AddOn::class, 'booking_item_add_ons')
					->withPivot('id', 'qty', 'unit_price', 'line_total', 'meta_snapshot')
					->withTimestamps();
	}

	public function pricing_lines()
	{
		return $this->hasMany(PricingLine::class);
	}
}
