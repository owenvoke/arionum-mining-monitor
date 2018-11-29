<?php

namespace App\Http\Requests;

use App\Exceptions\MiningMonitorException;
use App\User;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class ReportRequest
 */
class ReportRequest extends FormRequest
{
    /** @var User|null */
    public $user;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        $this->user = User::query()->where('report_token', $this->input('token'))->first() ?? null;

        return $this->user !== null;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'id' => 'string|required',
            'q' => 'string|optional|in:report,discovery',
            'type' => 'string|required',
        ];
    }

    /**
     * @param Validator $validator
     * @throws MiningMonitorException
     */
    protected function failedValidation(Validator $validator): void
    {
        throw new MiningMonitorException('invalid post');
    }

    /**
     * @throws MiningMonitorException
     */
    protected function failedAuthorization(): void
    {
        throw new MiningMonitorException('unauthorized');
    }
}
