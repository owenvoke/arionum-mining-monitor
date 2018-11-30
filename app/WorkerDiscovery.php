<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class WorkerDiscovery
 *
 * @property int         $id
 * @property int         $worker_id
 * @property int         $difficulty
 * @property int         $dl
 * @property string      $nonce
 * @property string      $argon
 * @property int         $retries
 * @property bool        $confirmed
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Worker|null $worker
 */
class WorkerDiscovery extends Model
{
    /** @var array */
    protected $casts = [
        'worker_id' => 'int',
        'difficulty' => 'int',
        'dl' => 'int',
        'retries' => 'float',
        'confirm' => 'bool',
    ];

    /**
     * @return BelongsTo|null
     */
    public function worker(): ?BelongsTo
    {
        return $this->belongsTo(Worker::class);
    }
}
