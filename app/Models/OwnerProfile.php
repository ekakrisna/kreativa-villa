<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class OwnerProfile
 * 
 * @property int $id
 * @property string|null $legal_name
 * @property string|null $tax_id
 * @property array|null $payout_details
 * @property array|null $business_settings
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class OwnerProfile extends Model
{
	protected $table = 'owner_profile';

	protected $casts = [
		'payout_details' => 'json',
		'business_settings' => 'json'
	];

	protected $fillable = [
		'legal_name',
		'tax_id',
		'payout_details',
		'business_settings'
	];
}
