<?php

namespace App\Http\Controllers;

use App\Exceptions\MiningMonitorException;
use App\Http\Requests\ReportRequest;
use App\User;
use App\Worker;
use App\WorkerDiscovery;
use App\WorkerReport;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * Class ReportsController
 */
class ReportsController extends Controller
{
    /** @var string|null */
    private $requestIp;

    /**
     * ReportController constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->requestIp = $request->getClientIp();
    }

    /**
     * Report index route
     * @param ReportRequest $request
     * @return array
     * @throws MiningMonitorException
     */
    public function index(ReportRequest $request): array
    {
        $workerName = $request->input('id');
        $type = $request->input('type');

        if (!$worker = $this->getWorkerByDetails($workerName, $type, $request->user)) {
            throw new MiningMonitorException('unregistered');
        }

        if ($request->input('q') === 'report') {
            $hashes = $request->input('hashes');
            $elapsed = $request->input('elapsed');
            $rate = bcdiv($hashes, $elapsed, 6) * 1000;

            WorkerReport::query()->insert([
                'worker_id' => $worker->id,
                'hashes' => $hashes,
                'elapsed' => $elapsed,
                'rate' => $rate,
            ]);

            return $this->respondWithJson('ok');
        }

        if ($request->input('q') === 'discovery') {
            WorkerDiscovery::query()->insert([
                'worker_id' => $worker->id,
                'nonce' => $request->input('nonce'),
                'argon' => $request->input('argon'),
                'difficulty' => (int)$request->input('difficulty'),
                'dl' => (int)$request->input('dl'),
                'retries' => (int)$request->input('retries'),
                'confirmed' => $request->input('confirmed') !== null,
            ]);

            return $this->respondWithJson('ok');
        }

        throw new MiningMonitorException('invalid post');
    }

    /**
     * Report errors route
     * @param ReportRequest $request
     * @return array
     * @throws MiningMonitorException
     */
    public function errors(ReportRequest $request): array
    {
        $workerName = $request->input('id');
        $type = $request->input('type');

        if (!$this->getWorkerByDetails($workerName, $type, $request->user)) {
            throw new MiningMonitorException('unregistered');
        }

        Log::error(null, $request->all());

        return $this->respondWithJson('ok');
    }

    /**
     * Generate a JSON response array.
     * @param mixed $data
     * @return array
     */
    private function respondWithJson($data): array
    {
        return [
            'coin' => config('arionum.report.coin'),
            'data' => $data,
            'status' => 'ok',
        ];
    }

    /**
     * @param string $workerName
     * @param string $type
     * @param User   $user
     * @return Builder|Model|Worker
     */
    private function getWorkerByDetails(string $workerName, string $type, User $user)
    {
        return Worker::query()
            ->where('user_id', $user->id)
            ->where('name', $workerName)
            ->where('ip', $this->requestIp)
            ->where('type', $type)
            ->firstOrCreate([
                'user_id' => $user->id,
                'name' => $workerName,
                'type' => $type,
                'ip' => $this->requestIp,
            ]);
    }
}
