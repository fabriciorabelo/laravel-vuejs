<?php

namespace App\Models;

use App\Permissions\HasPermissionsTrait;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * @OA\Schema(
 *     title="User",
 *     schema="user"
 * )
 *
 */
class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable, HasPermissionsTrait;

    /**
     * @OA\Property()
     * @var integer
     */
    private $id;

    /**
     * @OA\Property()
     * @var string
     */
    private $name;

    /**
     * @OA\Property()
     * @var string
     */
    private $email;

    /**
     * @OA\Property()
     * @var string
     */
    private $password;

    /**
     * @OA\Property()
     * @var DateTime
     */
    private $email_verified_at;

    /**
     * @OA\Property()
     * @var DateTime
     */
    private $created_at;

    /**
     * @OA\Property()
     * @var DateTime
     */
    private $updated_at;

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

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'users_permissions');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'users_roles');
    }
}
