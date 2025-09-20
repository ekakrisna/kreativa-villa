<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ProductVehicle
 * 
 * @property int $product_id
 * @property string $vehicle_type
 * @property string|null $brand
 * @property string|null $model
 * @property int|null $year
 * @property string|null $transmission
 * @property string|null $fuel_type
 * @property bool $driver_available
 * 
 * @property Product $product
 *
 * @package App\Models
 */
class ProductVehicle extends Model
{
	protected $table = 'product_vehicles';
	protected $primaryKey = 'product_id';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'product_id' => 'int',
		'year' => 'int',
		'driver_available' => 'bool'
	];

	protected $fillable = [
		'vehicle_type',
		'brand',
		'model',
		'year',
		'transmission',
		'fuel_type',
		'driver_available'
	];

	public function product()
	{
		return $this->belongsTo(Product::class);
	}
}
