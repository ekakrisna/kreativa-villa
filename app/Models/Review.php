<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Review
 * 
 * @property int $id
 * @property int $booking_id
 * @property int $product_id
 * @property int $user_id
 * @property int $rating
 * @property string|null $comment
 * @property Carbon|null $published_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Booking $booking
 * @property Product $product
 * @property User $user
 *
 * @package App\Models
 */
class Review extends Model
{
	protected $table = 'reviews';

	protected $casts = [
		'booking_id' => 'int',
		'product_id' => 'int',
		'user_id' => 'int',
		'rating' => 'int',
		'published_at' => 'datetime'
	];

	protected $fillable = [
		'booking_id',
		'product_id',
		'user_id',
		'rating',
		'comment',
		'published_at'
	];

	public function booking()
	{
		return $this->belongsTo(Booking::class);
	}

	public function product()
	{
		return $this->belongsTo(Product::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
