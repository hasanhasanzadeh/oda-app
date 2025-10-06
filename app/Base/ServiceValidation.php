<?php

namespace App\Base;

use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Support\Facades\DB;

class ServiceValidation
{
    public function __invoke(\Closure $action, \Closure $reject = null, bool $transaction = false): ServiceResult
    {
        !is_null($transaction) && DB::beginTransaction();
        try {
            $actionResult = $action();
            !is_null($transaction) && DB::commit();
            return new ServiceResult(true, $actionResult);

        } catch (\Throwable $throwable) {
            !is_null($transaction) && DB::rollBack();
            !is_null($reject) && $reject();
            app()[ExceptionHandler::class]->report($throwable);
            return new ServiceResult(true, $throwable->getMessage());
        }
    }
}
