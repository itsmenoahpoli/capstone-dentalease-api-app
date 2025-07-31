<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\{Request, Response, JSONResponse};
use App\Http\Requests\Services\{StoreServiceRequest, UpdateServiceRequest};
use App\Http\Resources\ServiceResource;
use App\Services\ServicesService;

class ServicesController extends Controller
{
    public function __construct(
        private ServicesService $servicesService
    ) {}

    public function index(): JSONResponse
    {
        $services = $this->servicesService->getAllServices();

        return response()->json([
            'data' => ServiceResource::collection($services)
        ], Response::HTTP_OK);
    }

    public function show(int $id): JSONResponse
    {
        $service = $this->servicesService->getServiceById($id);

        return response()->json([
            'data' => new ServiceResource($service)
        ], Response::HTTP_OK);
    }

    public function store(StoreServiceRequest $request): JSONResponse
    {
        $service = $this->servicesService->createService($request->validated());

        return response()->json([
            'data' => new ServiceResource($service)
        ], Response::HTTP_CREATED);
    }

    public function update(UpdateServiceRequest $request, int $id): JSONResponse
    {
        $service = $this->servicesService->updateService($id, $request->validated());

        return response()->json([
            'data' => new ServiceResource($service)
        ], Response::HTTP_OK);
    }

    public function destroy(int $id): JSONResponse
    {
        $this->servicesService->deleteService($id);

        return response()->json([
            'message' => 'Service deleted successfully'
        ], Response::HTTP_OK);
    }
}
