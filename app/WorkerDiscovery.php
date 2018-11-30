<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

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
 */
class WorkerDiscovery extends Model
{
}
