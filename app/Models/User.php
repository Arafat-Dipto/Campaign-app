<?php

namespace App\Models;

use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Shanmuga\LaravelEntrust\Traits\LaravelEntrustUserTrait;

class User extends Authenticatable implements MustVerifyEmail, JWTSubject
{
	use HasFactory, Notifiable;
	use LaravelEntrustUserTrait; // add this trait to your user model

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name',
		'email',
		'password',
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password',
		'remember_token',
	];

	/**
	 * The attributes that should be cast to native types.
	 *
	 * @var array
	 */
	protected $casts = [
		'email_verified_at' => 'datetime',
	];

	public function setPasswordAttribute($password)
	{
		$this->attributes['password'] = Hash::make($password);
	}

	public function isDemoUser()
	{
		return $this->email === 'arafat@dev.com.bd';
	}

	public function scopeFilter($query, array $filters)
	{
		$query->when($filters['search'] ?? null, function ($query, $search) {
			$query->where(function ($query) use ($search) {
				$query->where('name', 'like', '%' . $search . '%')
					->orWhere('email', 'like', '%' . $search . '%');
			});
		})->when($filters['role'] ?? null, function ($query, $role) {
			$query->withRole($role);
		})->when($filters['roles'] ?? null, function ($query, $role) {
			$roles = explode('--', $role);
			$query->whereHas('roles', function ($q) use ($roles) {
				$q->whereIn('name', $roles);
			});
		})->when($filters['trashed'] ?? null, function ($query, $trashed) {
			if ($trashed === 'with') {
				$query->withTrashed();
			} elseif ($trashed === 'only') {
				$query->onlyTrashed();
			}
		});
	}

	/**
	 * Get the identifier that will be stored in the subject claim of the JWT.
	 *
	 * @return mixed
	 */
	public function getJWTIdentifier()
	{
		return $this->getKey();
	}

	/**
	 * Return a key value array, containing any custom claims to be added to the JWT.
	 *
	 * @return array
	 */
	public function getJWTCustomClaims()
	{
		return [];
	}
}
