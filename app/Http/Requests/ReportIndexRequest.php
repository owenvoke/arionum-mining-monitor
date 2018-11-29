<?php

namespace App\Http\Requests;

use App\Exceptions\Api\InvalidReportTokenException;
use App\User;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class ReportIndexRequest
 */
class ReportIndexRequest extends FormRequest
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
            'q' => 'string|required|in:report,discovery',
            'type' => 'string|required',
        ];
    }

    /**
     * @throws InvalidReportTokenException
     */
    protected function failedAuthorization(): void
    {
        throw new InvalidReportTokenException('unauthorized');
    }
}
