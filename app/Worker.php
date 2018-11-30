<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Worker
 *
 * @property int             $id
 * @property int             $user_id
 * @property string          $name
 * @property string          $ip
 * @property string          $type
 * @property Carbon|null     $created_at
 * @property Carbon|null     $updated_at
 *
 * @property User|null       $user
 * @property Collection|null $discoveries
 * @property Collection|null $reports
 */
class Worker extends Model
{
    /** @var array */
    protected $fillable = [
        'user_id',
        'name',
        'ip',
        'type',
    ];

    /**
     * @return BelongsTo|null
     */
    public function user(): ?BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return HasMany|null
     */
    public function discoveries(): ?HasMany
    {
        return $this->hasMany(WorkerDiscovery::class);
    }

    /**
     * @return HasMany|null
     */
    public function reports(): ?HasMany
    {
        return $this->hasMany(WorkerReport::class);
    }
}
