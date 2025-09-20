<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class DynamicPricingRule
 * 
 * @property int $id
 * @property int $product_id
 * @property array $rule
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Product $product
 *
 * @package App\Models
 */
class DynamicPricingRule extends Model
{
	protected $table = 'dynamic_pricing_rules';

	protected $casts = [
		'product_id' => 'int',
		'rule' => 'json'
	];

	protected $fillable = [
		'product_id',
		'rule'
	];

	public function product()
	{
		return $this->belongsTo(Product::class);
	}
}
