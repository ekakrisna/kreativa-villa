<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MediaAsset
 * 
 * @property int $id
 * @property int $product_id
 * @property string $url
 * @property string $type
 * @property bool $is_cover
 * @property int $sort_order
 * @property array|null $meta
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Product $product
 *
 * @package App\Models
 */
class MediaAsset extends Model
{
	protected $table = 'media_assets';

	protected $casts = [
		'product_id' => 'int',
		'is_cover' => 'bool',
		'sort_order' => 'int',
		'meta' => 'json'
	];

	protected $fillable = [
		'product_id',
		'url',
		'type',
		'is_cover',
		'sort_order',
		'meta'
	];

	public function product()
	{
		return $this->belongsTo(Product::class);
	}
}
