<?php

namespace App\Http\Controllers;

use App\Worker;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * Class ReportController
 */
class ReportController extends Controller
{
    /**
     * Report index route
     */
    public function index(): void
    {
    }

    /**
     * Report errors route
     * @param Request $request
     * @return array
     */
    public function errors(Request $request): array
    {
        $ipAddress = $request->getClientIp();
        $token = $request->query('token');
        $workerName = $request->query('id');
        $type = $request->query('type');

        if (config('arionum.report.token') !== $token) {
            return $this->respondWithJson('unauthorized', true);
        }

        if (!Worker::query()
            ->where('name', $workerName)
            ->where('ip', $ipAddress)
            ->where('type', $type)
            ->firstOrCreate(['name' => $workerName, 'date' => Carbon::now(), 'type' => $type, 'ip' => $ipAddress])
        ) {
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
}
