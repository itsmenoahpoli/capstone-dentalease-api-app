<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\{Request, Response, JSONResponse};
use App\Http\Requests\Patients\{StorePatientRequest, UpdatePatientRequest};
use App\Http\Resources\PatientResource;
use App\Services\PatientsService;

/**
 * @OA\Schema(
 *     schema="Patient",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="John Doe"),
 *     @OA\Property(property="email", type="string", format="email", example="john.doe@example.com"),
 *     @OA\Property(property="contact", type="string", example="+1234567890"),
 *     @OA\Property(property="address", type="string", example="123 Main St, City, State 12345"),
 *     @OA\Property(property="gender", type="string", enum={"male","female","other"}, example="male"),
 *     @OA\Property(property="birthdate", type="string", format="date", example="1990-01-01"),
 *     @OA\Property(property="citizenship", type="string", example="American"),
 *     @OA\Property(property="status", type="string", enum={"active","inactive"}, example="active"),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2025-07-31T09:10:00.000000Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-07-31T09:10:00.000000Z")
 * )
 */
class PatientsController extends Controller
{
    public function __construct(
        private PatientsService $patientsService
    ) {}

    /**
     * @OA\Get(
     *     path="/patients",
     *     tags={"Patients"},
     *     summary="Get all patients",
     *     description="Retrieve a list of all patients",
     *     @OA\Response(
     *         response=200,
     *         description="List of patients",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Patient"))
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
        $patients = $this->patientsService->getAllPatients();

        return response()->json(PatientResource::collection($patients), Response::HTTP_OK);
    }

    /**
     * @OA\Get(
     *     path="/patients/{id}",
     *     tags={"Patients"},
     *     summary="Get a specific patient",
     *     description="Retrieve a specific patient by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer", minimum=1),
     *         example=1
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Patient details",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", ref="#/components/schemas/Patient")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Patient not found"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error"
     *     )
     * )
     */
    public function show(int $id): JSONResponse
    {
        $patient = $this->patientsService->getPatientById($id);

        return response()->json(new PatientResource($patient), Response::HTTP_OK);
    }

    /**
     * @OA\Post(
     *     path="/patients",
     *     tags={"Patients"},
     *     summary="Create a new patient",
     *     description="Create a new patient record",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name","email","contact","address","gender","birthdate","citizenship"},
     *             @OA\Property(property="name", type="string", example="John Doe"),
     *             @OA\Property(property="email", type="string", format="email", example="john.doe@example.com"),
     *             @OA\Property(property="contact", type="string", example="+1234567890"),
     *             @OA\Property(property="address", type="string", example="123 Main St, City, State 12345"),
     *             @OA\Property(property="gender", type="string", enum={"male","female","other"}, example="male"),
     *             @OA\Property(property="birthdate", type="string", format="date", example="1990-01-01"),
     *             @OA\Property(property="citizenship", type="string", example="American"),
     *             @OA\Property(property="status", type="string", enum={"active","inactive"}, example="active")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Patient created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", ref="#/components/schemas/Patient")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error"
     *     )
     * )
     */
    public function store(StorePatientRequest $request): JSONResponse
    {
        $patient = $this->patientsService->createPatient($request->validated());

        return response()->json(new PatientResource($patient), Response::HTTP_CREATED);
    }

    /**
     * @OA\Put(
     *     path="/patients/{id}",
     *     tags={"Patients"},
     *     summary="Update a patient",
     *     description="Update an existing patient record",
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
     *             @OA\Property(property="name", type="string", example="John Doe"),
     *             @OA\Property(property="email", type="string", format="email", example="john.doe@example.com"),
     *             @OA\Property(property="contact", type="string", example="+1234567890"),
     *             @OA\Property(property="address", type="string", example="123 Main St, City, State 12345"),
     *             @OA\Property(property="gender", type="string", enum={"male","female","other"}, example="male"),
     *             @OA\Property(property="birthdate", type="string", format="date", example="1990-01-01"),
     *             @OA\Property(property="citizenship", type="string", example="American"),
     *             @OA\Property(property="status", type="string", enum={"active","inactive"}, example="active")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Patient updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", ref="#/components/schemas/Patient")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Patient not found"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error"
     *     )
     * )
     */
    public function update(UpdatePatientRequest $request, int $id): JSONResponse
    {
        $patient = $this->patientsService->updatePatient($id, $request->validated());

        return response()->json(new PatientResource($patient), Response::HTTP_OK);
    }

    /**
     * @OA\Delete(
     *     path="/patients/{id}",
     *     tags={"Patients"},
     *     summary="Delete a patient",
     *     description="Delete a patient record",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer", minimum=1),
     *         example=1
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Patient deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Patient deleted successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Patient not found"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error"
     *     )
     * )
     */
    public function destroy(int $id): JSONResponse
    {
        $this->patientsService->deletePatient($id);

        return response()->json(['message' => 'Patient deleted successfully'], Response::HTTP_OK);
    }
}
