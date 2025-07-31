<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\{Request, Response, JSONResponse};
use App\Http\Requests\Services\{StoreServiceRequest, UpdateServiceRequest};
use App\Http\Resources\ServiceResource;
use App\Services\ServicesService;

/**
 * @OA\Schema(
 *     schema="Service",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="category", type="string", example="Dental Cleaning"),
 *     @OA\Property(property="name", type="string", example="Regular Cleaning"),
 *     @OA\Property(property="price", type="string", format="decimal", example="150.00"),
 *     @OA\Property(property="status", type="string", enum={"offered","draft"}, example="offered"),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2025-07-31T09:10:00.000000Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-07-31T09:10:00.000000Z")
 * )
 */
class ServicesController extends Controller
{
    public function __construct(
        private ServicesService $servicesService
    ) {}

    /**
     * @OA\Get(
     *     path="/services",
     *     tags={"Services"},
     *     summary="Get all services",
     *     description="Retrieve a list of all dental services",
     *     @OA\Response(
     *         response=200,
     *         description="List of services",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Service"))
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error"
     *     )
     * )
     */
    public function index(): JSONResponse
    {
        $services = $this->servicesService->getAllServices();

        return response()->json([
            'data' => ServiceResource::collection($services)
        ], Response::HTTP_OK);
    }

    /**
     * @OA\Get(
     *     path="/services/{id}",
     *     tags={"Services"},
     *     summary="Get a specific service",
     *     description="Retrieve a specific dental service by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer", minimum=1),
     *         example=1
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Service details",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", ref="#/components/schemas/Service")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Service not found"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error"
     *     )
     * )
     */
    public function show(int $id): JSONResponse
    {
        $service = $this->servicesService->getServiceById($id);

        return response()->json([
            'data' => new ServiceResource($service)
        ], Response::HTTP_OK);
    }

    /**
     * @OA\Post(
     *     path="/services",
     *     tags={"Services"},
     *     summary="Create a new service",
     *     description="Create a new dental service",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"category","name","price","status"},
     *             @OA\Property(property="category", type="string", maxLength=255, example="Dental Cleaning"),
     *             @OA\Property(property="name", type="string", maxLength=255, example="Regular Cleaning"),
     *             @OA\Property(property="price", type="number", minimum=0, example=150.00),
     *             @OA\Property(property="status", type="string", enum={"offered","draft"}, example="offered")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Service created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", ref="#/components/schemas/Service")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Validation error"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error"
     *     )
     * )
     */
    public function store(StoreServiceRequest $request): JSONResponse
    {
        $service = $this->servicesService->createService($request->validated());

        return response()->json([
            'data' => new ServiceResource($service)
        ], Response::HTTP_CREATED);
    }

    /**
     * @OA\Put(
     *     path="/services/{id}",
     *     tags={"Services"},
     *     summary="Update a service",
     *     description="Update an existing dental service",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer", minimum=1),
     *         example=1
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="category", type="string", maxLength=255, example="Dental Cleaning"),
     *             @OA\Property(property="name", type="string", maxLength=255, example="Premium Cleaning"),
     *             @OA\Property(property="price", type="number", minimum=0, example=200.00),
     *             @OA\Property(property="status", type="string", enum={"offered","draft"}, example="offered")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Service updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", ref="#/components/schemas/Service")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Validation error"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Service not found"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error"
     *     )
     * )
     */
    public function update(UpdateServiceRequest $request, int $id): JSONResponse
    {
        $service = $this->servicesService->updateService($id, $request->validated());

        return response()->json([
            'data' => new ServiceResource($service)
        ], Response::HTTP_OK);
    }

    /**
     * @OA\Delete(
     *     path="/services/{id}",
     *     tags={"Services"},
     *     summary="Delete a service",
     *     description="Delete a dental service",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer", minimum=1),
     *         example=1
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Service deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Service deleted successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Service not found"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error"
     *     )
     * )
     */
    public function destroy(int $id): JSONResponse
    {
        $this->servicesService->deleteService($id);

        return response()->json([
            'message' => 'Service deleted successfully'
        ], Response::HTTP_OK);
    }
}
