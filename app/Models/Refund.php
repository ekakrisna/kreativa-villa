<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Refund
 * 
 * @property int $id
 * @property int $payment_id
 * @property float $amount
 * @property string|null $reason
 * @property string $status
 * @property array|null $raw_response
 * @property Carbon|null $refunded_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Payment $payment
 *
 * @package App\Models
 */
class Refund extends Model
{
	protected $table = 'refunds';

	protected $casts = [
		'payment_id' => 'int',
		'amount' => 'float',
		'raw_response' => 'json',
		'refunded_at' => 'datetime'
	];

	protected $fillable = [
		'payment_id',
		'amount',
		'reason',
		'status',
		'raw_response',
		'refunded_at'
	];

	public function payment()
	{
		return $this->belongsTo(Payment::class);
	}
}
