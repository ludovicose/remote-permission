<?php
declare(strict_types=1);

namespace Spark\RemotePermission;

use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

/**
 * Class PermissionCheck
 * @package Spark\RemotePermission
 */
final class PermissionCheck
{
    /**
     * @var int
     */
    private $trueStatus;

    /**
     * @var int
     */
    private $falseStatus;

    /**
     * @var string|\Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|mixed
     */
    private $serverAddress;

    /**
     * @var string|\Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|mixed
     */
    private $serverUri;

    /**
     * PermissionCheck constructor.
     */
    public function __construct()
    {
        $this->serverAddress = config('permission.server-address');
        $this->serverUri     = config('permission.server-uri');
        $this->trueStatus    = (int)config('permission.true-status');
        $this->falseStatus   = (int)config('permission.false-status');
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

        $response = Http::retry(3, 100)->get((string)$path);

        if (in_array($response->status(), [$this->trueStatus, $this->falseStatus])) {
            return $response->status() == $this->trueStatus;
        }

        throw new Exception('Нету такого доступа', $response->status());
    }
}
