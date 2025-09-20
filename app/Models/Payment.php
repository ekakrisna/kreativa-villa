<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Payment
 * 
 * @property int $id
 * @property int $booking_id
 * @property string $provider
 * @property string|null $method
 * @property float $amount
 * @property string $currency
 * @property string $status
 * @property string $reference_id
 * @property array|null $raw_response
 * @property Carbon|null $paid_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Booking $booking
 * @property Collection|Refund[] $refunds
 *
 * @package App\Models
 */
class Payment extends Model
{
	protected $table = 'payments';

	protected $casts = [
		'booking_id' => 'int',
		'amount' => 'float',
		'raw_response' => 'json',
		'paid_at' => 'datetime'
	];

	protected $fillable = [
		'booking_id',
		'provider',
		'method',
		'amount',
		'currency',
		'status',
		'reference_id',
		'raw_response',
		'paid_at'
	];

	public function booking()
	{
		return $this->belongsTo(Booking::class);
	}

	public function refunds()
	{
		return $this->hasMany(Refund::class);
	}
}
