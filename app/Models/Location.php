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
 * Class Location
 * 
 * @property int $id
 * @property string|null $label
 * @property string|null $address_line
 * @property string|null $city
 * @property string|null $province
 * @property string|null $country
 * @property string|null $postal_code
 * @property float|null $latitude
 * @property float|null $longitude
 * @property string|null $type
 * @property array|null $metadata
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * 
 * @property Collection|Product[] $products
 * @property Collection|ProductTour[] $product_tours
 *
 * @package App\Models
 */
class Location extends Model
{
	use SoftDeletes;
	protected $table = 'locations';

	protected $casts = [
		'latitude' => 'float',
		'longitude' => 'float',
		'metadata' => 'json'
	];

	protected $fillable = [
		'label',
		'address_line',
		'city',
		'province',
		'country',
		'postal_code',
		'latitude',
		'longitude',
		'type',
		'metadata'
	];

	public function products()
	{
		return $this->hasMany(Product::class);
	}

	public function product_tours()
	{
		return $this->hasMany(ProductTour::class, 'default_meeting_point_location_id');
	}
}
