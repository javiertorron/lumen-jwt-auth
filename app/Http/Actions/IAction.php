<?php

namespace App\Http\Actions;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

interface IAction
{
    public function response(Request $request): JsonResponse;
}
