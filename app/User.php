<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Class User
 *
 * @property int             $id
 * @property string          $username
 * @property string          $email
 * @property Carbon|null     $email_verified_at
 * @property string          $password
 * @property string          $remember_token
 * @property string          $report_token
 * @property Carbon|null     $created_at
 * @property Carbon|null     $updated_at
 *
 * @property Collection|null $workers
 */
class User extends Authenticatable
{
    use Notifiable;

    /** @var array */
    protected $fillable = [
        'username',
        'email',
        'password',
        'report_token',
    ];

    /** @var array */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * @return HasMany|null
     */
    public function workers(): ?HasMany
    {
        return $this->hasMany(Worker::class);
    }
}
