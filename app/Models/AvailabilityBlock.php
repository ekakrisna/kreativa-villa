<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AvailabilityBlock
 * 
 * @property int $id
 * @property int $product_id
 * @property int|null $product_unit_id
 * @property string $type
 * @property Carbon $start_datetime
 * @property Carbon $end_datetime
 * @property string|null $note
 * @property int|null $created_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property User|null $user
 * @property Product $product
 * @property ProductUnit|null $product_unit
 *
 * @package App\Models
 */
class AvailabilityBlock extends Model
{
	protected $table = 'availability_blocks';

	protected $casts = [
		'product_id' => 'int',
		'product_unit_id' => 'int',
		'start_datetime' => 'datetime',
		'end_datetime' => 'datetime',
		'created_by' => 'int'
	];

	protected $fillable = [
		'product_id',
		'product_unit_id',
		'type',
		'start_datetime',
		'end_datetime',
		'note',
		'created_by'
	];

	public function user()
	{
		return $this->belongsTo(User::class, 'created_by');
	}

	public function product()
	{
		return $this->belongsTo(Product::class);
	}

	public function product_unit()
	{
		return $this->belongsTo(ProductUnit::class);
	}
}
