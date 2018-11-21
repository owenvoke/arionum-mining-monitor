<?php

namespace App\Http\Controllers;

use App\Http\Middleware\VerifyReportToken;
use App\Worker;
use App\WorkerDiscovery;
use App\WorkerReport;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * Class ReportController
 */
class ReportController extends Controller
{
    /** @var string|null */
    private $requestIp;

    /**
     * ReportController constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->middleware(VerifyReportToken::class);
        $this->requestIp = $request->getClientIp();
    }

    /**
     * Report index route
     * @param Request $request
     * @return array
     */
    public function index(Request $request): array
    {
        $queryType = $request->get('q');
        $workerName = $request->query('id');
        $type = $request->query('type');

        if (!$worker = $this->getWorkerByDetails($workerName, $type)) {
            $this->respondWithJson('unregistered', true);
        }

        if ($queryType === 'report') {
            $hashes = $request->get('hashes');
            $elapsed = $request->get('elapsed');
            $rate = bcdiv($hashes, $elapsed, 6) * 1000;

            WorkerReport::query()->updateOrInsert(['worker' => $worker->id], [
                'date'    => Carbon::now(),
                'hashes'  => $hashes,
                'elapsed' => $elapsed,
                'rate'    => $rate,
            ]);

            return $this->respondWithJson('ok');
        }

        if ($queryType === 'discovery') {
            WorkerDiscovery::query()->updateOrInsert(['worker' => $worker->id], [
                'date'       => Carbon::now(),
                'nonce'      => $request->get('nonce'),
                'argon'      => $request->get('argon'),
                'difficulty' => (int)$request->get('difficulty'),
                'dl'         => (int)$request->get('dl'),
                'retries'    => (int)$request->get('retries'),
                'confirmed'  => $request->get('confirmed') !== null,
            ]);

            return $this->respondWithJson('ok');
        }

        return $this->respondWithJson('invalid post', true);
    }

    /**
     * Report errors route
     * @param Request $request
     * @return array
     */
    public function errors(Request $request): array
    {
        $workerName = $request->query('id');
        $type = $request->query('type');

        if (!$this->getWorkerByDetails($workerName, $type)) {
            $this->respondWithJson('unregistered', true);
        }

        Log::error(null, $request->all());

        return $this->respondWithJson('ok');
    }

    /**
     * Generate a JSON response array.
     * @param mixed     $data
     * @param bool|null $isError
     * @return array
     */
    private function respondWithJson($data, ?bool $isError = null): array
    {
        return [
            'coin'   => config('arionum.report.coin'),
            'data'   => $data,
            'status' => $isError ? 'error' : 'ok',
        ];
    }

    /**
     * @param             $workerName
     * @param             $type
     * @return Builder|Model|Worker
     */
    private function getWorkerByDetails($workerName, $type)
    {
        return Worker::query()
            ->where('name', $workerName)
            ->where('ip', $this->requestIp)
            ->where('type', $type)
            ->firstOrCreate(['name' => $workerName, 'date' => Carbon::now(), 'type' => $type, 'ip' => $ipAddress]);
    }
}
