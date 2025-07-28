<?php 

namespace App\Application\Handler;

use App\Models\ImportRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ImportListRequestHandler implements ImportListRequestHandlerInterface
{
    /**
     * Handle the request to list imports.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function handleListRequest(Request $request): JsonResponse
    {
        $query = ImportRequest::query();

        if ($request->has('id')) {
            $query->where('id', $request->id);
        }

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        return response()->json($query->latest()->get());
    }
}