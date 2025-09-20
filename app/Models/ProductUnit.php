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
 * Class ProductUnit
 * 
 * @property int $id
 * @property int $product_id
 * @property string $code
 * @property string|null $serial_no
 * @property string $status
 * @property array|null $metadata
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * 
 * @property Product $product
 * @property Collection|AvailabilityBlock[] $availability_blocks
 * @property Collection|BookingItem[] $booking_items
 *
 * @package App\Models
 */
class ProductUnit extends Model
{
	use SoftDeletes;
	protected $table = 'product_units';

	protected $casts = [
		'product_id' => 'int',
		'metadata' => 'json'
	];

	protected $fillable = [
		'product_id',
		'code',
		'serial_no',
		'status',
		'metadata'
	];

	public function product()
	{
		return $this->belongsTo(Product::class);
	}

	public function availability_blocks()
	{
		return $this->hasMany(AvailabilityBlock::class);
	}

	public function booking_items()
	{
		return $this->hasMany(BookingItem::class);
	}
}
