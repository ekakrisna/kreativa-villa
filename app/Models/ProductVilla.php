<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ProductVilla
 * 
 * @property int $product_id
 * @property int $bedrooms
 * @property int $bathrooms
 * @property array|null $amenities
 * @property Carbon|null $checkin_time
 * @property Carbon|null $checkout_time
 * @property float|null $cleaning_fee
 * 
 * @property Product $product
 *
 * @package App\Models
 */
class ProductVilla extends Model
{
	protected $table = 'product_villas';
	protected $primaryKey = 'product_id';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'product_id' => 'int',
		'bedrooms' => 'int',
		'bathrooms' => 'int',
		'amenities' => 'json',
		'checkin_time' => 'datetime',
		'checkout_time' => 'datetime',
		'cleaning_fee' => 'float'
	];

	protected $fillable = [
		'bedrooms',
		'bathrooms',
		'amenities',
		'checkin_time',
		'checkout_time',
		'cleaning_fee'
	];

	public function product()
	{
		return $this->belongsTo(Product::class);
	}
}
