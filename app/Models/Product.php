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
 * Class Product
 * 
 * @property int $id
 * @property string $type
 * @property string $title
 * @property string $slug
 * @property string|null $description
 * @property string $base_currency
 * @property float $base_rate
 * @property string $rate_unit
 * @property int|null $capacity
 * @property float|null $deposit_amount
 * @property int|null $location_id
 * @property array|null $policy
 * @property string $status
 * @property Carbon|null $published_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * 
 * @property Location|null $location
 * @property Collection|AvailabilityBlock[] $availability_blocks
 * @property Collection|BookingItem[] $booking_items
 * @property Collection|DynamicPricingRule[] $dynamic_pricing_rules
 * @property Collection|MediaAsset[] $media_assets
 * @property Collection|AddOn[] $add_ons
 * @property Collection|ProductCategory[] $product_categories
 * @property ProductHelmet|null $product_helmet
 * @property Collection|Location[] $locations
 * @property ProductTour|null $product_tour
 * @property Collection|ProductUnit[] $product_units
 * @property ProductVehicle|null $product_vehicle
 * @property ProductVilla|null $product_villa
 * @property Collection|Review[] $reviews
 * @property Collection|SeasonalPricing[] $seasonal_pricings
 *
 * @package App\Models
 */
class Product extends Model
{
	use SoftDeletes;
	protected $table = 'products';

	protected $casts = [
		'base_rate' => 'float',
		'capacity' => 'int',
		'deposit_amount' => 'float',
		'location_id' => 'int',
		'policy' => 'json',
		'published_at' => 'datetime'
	];

	protected $fillable = [
		'type',
		'title',
		'slug',
		'description',
		'base_currency',
		'base_rate',
		'rate_unit',
		'capacity',
		'deposit_amount',
		'location_id',
		'policy',
		'status',
		'published_at'
	];

	public function location()
	{
		return $this->belongsTo(Location::class);
	}

	public function availability_blocks()
	{
		return $this->hasMany(AvailabilityBlock::class);
	}

	public function booking_items()
	{
		return $this->hasMany(BookingItem::class);
	}

	public function dynamic_pricing_rules()
	{
		return $this->hasMany(DynamicPricingRule::class);
	}

	public function media_assets()
	{
		return $this->hasMany(MediaAsset::class);
	}

	public function add_ons()
	{
		return $this->belongsToMany(AddOn::class, 'product_add_ons')
					->withPivot('id', 'overrides')
					->withTimestamps();
	}

	public function product_categories()
	{
		return $this->hasMany(ProductCategory::class);
	}

	public function product_helmet()
	{
		return $this->hasOne(ProductHelmet::class);
	}

	public function locations()
	{
		return $this->belongsToMany(Location::class, 'product_locations')
					->withPivot('id', 'purpose')
					->withTimestamps();
	}

	public function product_tour()
	{
		return $this->hasOne(ProductTour::class);
	}

	public function product_units()
	{
		return $this->hasMany(ProductUnit::class);
	}

	public function product_vehicle()
	{
		return $this->hasOne(ProductVehicle::class);
	}

	public function product_villa()
	{
		return $this->hasOne(ProductVilla::class);
	}

	public function reviews()
	{
		return $this->hasMany(Review::class);
	}

	public function seasonal_pricings()
	{
		return $this->hasMany(SeasonalPricing::class);
	}
}
