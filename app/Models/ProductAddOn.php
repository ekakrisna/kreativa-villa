<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ProductAddOn
 * 
 * @property int $id
 * @property int $product_id
 * @property int $add_on_id
 * @property array|null $overrides
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property AddOn $add_on
 * @property Product $product
 *
 * @package App\Models
 */
class ProductAddOn extends Model
{
	protected $table = 'product_add_ons';

	protected $casts = [
		'product_id' => 'int',
		'add_on_id' => 'int',
		'overrides' => 'json'
	];

	protected $fillable = [
		'product_id',
		'add_on_id',
		'overrides'
	];

	public function add_on()
	{
		return $this->belongsTo(AddOn::class);
	}

	public function product()
	{
		return $this->belongsTo(Product::class);
	}
}
