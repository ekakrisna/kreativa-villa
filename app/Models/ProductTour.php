<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ProductTour
 * 
 * @property int $product_id
 * @property int|null $duration_hours
 * @property bool $is_fixed_departure
 * @property int|null $default_meeting_point_location_id
 * @property array|null $itinerary
 * @property array|null $includes
 * @property array|null $excludes
 * 
 * @property Location|null $location
 * @property Product $product
 *
 * @package App\Models
 */
class ProductTour extends Model
{
	protected $table = 'product_tours';
	protected $primaryKey = 'product_id';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'product_id' => 'int',
		'duration_hours' => 'int',
		'is_fixed_departure' => 'bool',
		'default_meeting_point_location_id' => 'int',
		'itinerary' => 'json',
		'includes' => 'json',
		'excludes' => 'json'
	];

	protected $fillable = [
		'duration_hours',
		'is_fixed_departure',
		'default_meeting_point_location_id',
		'itinerary',
		'includes',
		'excludes'
	];

	public function location()
	{
		return $this->belongsTo(Location::class, 'default_meeting_point_location_id');
	}

	public function product()
	{
		return $this->belongsTo(Product::class);
	}
}
