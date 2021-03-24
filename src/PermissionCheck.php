<?php
declare(strict_types=1);

namespace Spark\RemotePermission;

use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

final class PermissionCheck
{
    private int $trueStatus;

    private int $falseStatus;

    private string $serverAddress;

    private string $serverUri;

    /**
     * PermissionCheck constructor.
     */
    public function __construct()
    {
        $this->serverAddress = config('permission.server-address');
        $this->serverUri = config('permission.server-uri');
        $this->trueStatus = (int)config('permission.true-status');
        $this->falseStatus = (int)config('permission.false-status');
    }

    /**
     * @param int $userId
     * @param string $permission
     * @return mixed
     * @throws Exception
     */
    public function check(int $userId, string $permission)
    {
        $path = Str::of($this->serverUri)
            ->replace('{userId}', $userId)
            ->replace('{permission}', $permission)
            ->prepend($this->serverAddress);

        $response = Http::get((string)$path);

        if (in_array($response->status(), [$this->trueStatus, $this->falseStatus])) {
            return $response->status();
        }

        throw new Exception('Пришел некорректный ответ от сервера', $response->status());
    }
}
