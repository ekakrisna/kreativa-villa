<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ProductHelmet
 * 
 * @property int $product_id
 * @property string|null $size
 * @property string|null $standard_cert
 * 
 * @property Product $product
 *
 * @package App\Models
 */
class ProductHelmet extends Model
{
	protected $table = 'product_helmets';
	protected $primaryKey = 'product_id';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'product_id' => 'int'
	];

	protected $fillable = [
		'size',
		'standard_cert'
	];

	public function product()
	{
		return $this->belongsTo(Product::class);
	}
}
