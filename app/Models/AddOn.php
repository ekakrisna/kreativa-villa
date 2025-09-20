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
 * Class AddOn
 * 
 * @property int $id
 * @property string $title
 * @property string|null $description
 * @property float $price
 * @property string $price_unit
 * @property bool $required
 * @property string $applicable_to
 * @property bool $is_inventory_tracked
 * @property int|null $inventory_qty
 * @property array|null $metadata
 * @property string $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * 
 * @property Collection|BookingItem[] $booking_items
 * @property Collection|Product[] $products
 *
 * @package App\Models
 */
class AddOn extends Model
{
	use SoftDeletes;
	protected $table = 'add_ons';

	protected $casts = [
		'price' => 'float',
		'required' => 'bool',
		'is_inventory_tracked' => 'bool',
		'inventory_qty' => 'int',
		'metadata' => 'json'
	];

	protected $fillable = [
		'title',
		'description',
		'price',
		'price_unit',
		'required',
		'applicable_to',
		'is_inventory_tracked',
		'inventory_qty',
		'metadata',
		'status'
	];

	public function booking_items()
	{
		return $this->belongsToMany(BookingItem::class, 'booking_item_add_ons')
					->withPivot('id', 'qty', 'unit_price', 'line_total', 'meta_snapshot')
					->withTimestamps();
	}

	public function products()
	{
		return $this->belongsToMany(Product::class, 'product_add_ons')
					->withPivot('id', 'overrides')
					->withTimestamps();
	}
}
