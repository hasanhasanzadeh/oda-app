<?php

namespace App\Repositories;

use Carbon\Carbon;
use App\Models\ActivationCode;
use Illuminate\Support\Facades\DB;
use App\Repositories\Interfaces\ActivationCodeRepositoryInterface;

class ActivationCodeRepository implements ActivationCodeRepositoryInterface
{
    public function create($user)
    {
        return ActivationCode::createCode($user)->code;
    }

    public function findByCode($code, $userId)
    {
        return ActivationCode::where('code', $code)->where('user_id', $userId)->where('used',0)->where('expired_at','>',Carbon::now())->first();
    }

    public function expiredCode($userId)
    {
        return ActivationCode::where('user_id', $userId)->where('used',0)->where('expired_at','>',Carbon::now())->first();
    }

    public function deleteAll($userId): int
    {
      return DB::table('activation_codes')->where('user_id', $userId)->delete();
    }
}
