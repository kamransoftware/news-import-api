<?php 

namespace App\Application\Handler;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

interface ImportListRequestHandlerInterface
{
    /**
     * Handle the request to list imports.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function handleListRequest(Request $request): JsonResponse;
}