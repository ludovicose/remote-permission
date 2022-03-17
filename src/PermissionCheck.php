<?php
declare(strict_types=1);

namespace Ludovicose\RemotePermission;

use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

/**
 * Class PermissionCheck
 * @package Spark\RemotePermission
 */
final class PermissionCheck
{
    private int $trueStatus;

    private int $falseStatus;

    private string $serverAddress;

    private string $serverUri;

    private bool $debug;

    private int $ttl;

    public function __construct()
    {
        $this->serverAddress = config('permission.server-address');
        $this->serverUri     = config('permission.server-uri');
        $this->trueStatus    = (int)config('permission.true-status');
        $this->falseStatus   = (int)config('permission.false-status');
        $this->ttl           = (int)config('permission.ttl');
        $this->debug         = config('permission.debug');
    }

    public function check(int $userId, string $permission): bool
    {
        if ($this->debug) {
            return true;
        }

        $response = Cache::remember(
            "remote_permission_check_{$userId}_permission_{$permission}",
            $this->ttl,
            fn() => $this->hasPermission($userId, $permission)
        );

        if (in_array($response, [$this->trueStatus, $this->falseStatus])) {
            return $response == $this->trueStatus;
        }

        throw new Exception('Нету такого доступа', $response->status());
    }

    private function hasPermission(int $userId, string $permission): int
    {
        $path = Str::of($this->serverUri)
            ->replace('{userId}', $userId)
            ->replace('{permission}', $permission)
            ->prepend($this->serverAddress);

        $response = Http::retry(3, 100)->get((string)$path);

        return $response->status();
    }
}
