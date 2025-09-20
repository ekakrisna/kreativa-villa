<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ProductLocation
 * 
 * @property int $id
 * @property int $product_id
 * @property int $location_id
 * @property string $purpose
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Location $location
 * @property Product $product
 *
 * @package App\Models
 */
class ProductLocation extends Model
{
	protected $table = 'product_locations';

	protected $casts = [
		'product_id' => 'int',
		'location_id' => 'int'
	];

	protected $fillable = [
		'product_id',
		'location_id',
		'purpose'
	];

	public function location()
	{
		return $this->belongsTo(Location::class);
	}

	public function product()
	{
		return $this->belongsTo(Product::class);
	}
}
