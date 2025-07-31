<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\{Request, Response, JSONResponse};
use App\Http\Requests\Appointments\{StoreAppointmentRequest, UpdateAppointmentRequest};
use App\Http\Resources\AppointmentResource;
use App\Services\AppointmentsService;

/**
 * @OA\Schema(
 *     schema="Appointment",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="patient_name", type="string", example="John Doe"),
 *     @OA\Property(property="patient_email", type="string", example="john.doe@example.com"),
 *     @OA\Property(property="patient_contact", type="string", example="+1234567890"),
 *     @OA\Property(property="purpose", type="string", example="Regular dental checkup"),
 *     @OA\Property(property="remarks", type="string", example="Patient has sensitive teeth"),
 *     @OA\Property(property="schedule_time", type="string", format="time", example="14:30"),
 *     @OA\Property(property="schedule_date", type="string", format="date", example="2025-08-15"),
 *     @OA\Property(property="status", type="string", enum={"pending","active","past_due","cancelled"}, example="pending"),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2025-07-31T09:10:00.000000Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-07-31T09:10:00.000000Z")
 * )
 */
class AppointmentsController extends Controller
{
    public function __construct(
        private AppointmentsService $appointmentsService
    ) {}

    /**
     * @OA\Get(
     *     path="/appointments",
     *     tags={"Appointments"},
     *     summary="Get all appointments",
     *     description="Retrieve a list of all appointments",
     *     @OA\Response(
     *         response=200,
     *         description="List of appointments",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Appointment"))
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
        $appointments = $this->appointmentsService->getAllAppointments();

        return response()->json(AppointmentResource::collection($appointments), Response::HTTP_OK);
    }

    /**
     * @OA\Get(
     *     path="/appointments/{id}",
     *     tags={"Appointments"},
     *     summary="Get a specific appointment",
     *     description="Retrieve a specific appointment by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer", minimum=1),
     *         example=1
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Appointment details",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", ref="#/components/schemas/Appointment")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Appointment not found"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error"
     *     )
     * )
     */
    public function show(int $id): JSONResponse
    {
        $appointment = $this->appointmentsService->getAppointmentById($id);

        return response()->json(new AppointmentResource($appointment), Response::HTTP_OK);
    }

    /**
     * @OA\Post(
     *     path="/appointments",
     *     tags={"Appointments"},
     *     summary="Create a new appointment",
     *     description="Create a new appointment",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"patient_name","patient_email","patient_contact","purpose","schedule_time","schedule_date","status"},
     *             @OA\Property(property="patient_name", type="string", example="John Doe"),
     *             @OA\Property(property="patient_email", type="string", format="email", example="john.doe@example.com"),
     *             @OA\Property(property="patient_contact", type="string", example="+1234567890"),
     *             @OA\Property(property="purpose", type="string", example="Regular dental checkup"),
     *             @OA\Property(property="remarks", type="string", example="Patient has sensitive teeth"),
     *             @OA\Property(property="schedule_time", type="string", format="time", example="14:30"),
     *             @OA\Property(property="schedule_date", type="string", format="date", example="2025-08-15"),
     *             @OA\Property(property="status", type="string", enum={"pending","active","past_due","cancelled"}, example="pending")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Appointment created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", ref="#/components/schemas/Appointment")
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
    public function store(StoreAppointmentRequest $request): JSONResponse
    {
        $appointment = $this->appointmentsService->createAppointment($request->validated());

        return response()->json(new AppointmentResource($appointment), Response::HTTP_CREATED);
    }

    /**
     * @OA\Put(
     *     path="/appointments/{id}",
     *     tags={"Appointments"},
     *     summary="Update an appointment",
     *     description="Update an existing appointment",
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
     *             @OA\Property(property="patient_name", type="string", example="John Doe"),
     *             @OA\Property(property="patient_email", type="string", format="email", example="john.doe@example.com"),
     *             @OA\Property(property="patient_contact", type="string", example="+1234567890"),
     *             @OA\Property(property="purpose", type="string", example="Regular dental checkup"),
     *             @OA\Property(property="remarks", type="string", example="Patient has sensitive teeth"),
     *             @OA\Property(property="schedule_time", type="string", format="time", example="14:30"),
     *             @OA\Property(property="schedule_date", type="string", format="date", example="2025-08-15"),
     *             @OA\Property(property="status", type="string", enum={"pending","active","past_due","cancelled"}, example="active")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Appointment updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", ref="#/components/schemas/Appointment")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Appointment not found"
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
    public function update(UpdateAppointmentRequest $request, int $id): JSONResponse
    {
        $appointment = $this->appointmentsService->updateAppointment($id, $request->validated());

        return response()->json(new AppointmentResource($appointment), Response::HTTP_OK);
    }

    /**
     * @OA\Delete(
     *     path="/appointments/{id}",
     *     tags={"Appointments"},
     *     summary="Delete an appointment",
     *     description="Delete an existing appointment",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer", minimum=1),
     *         example=1
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Appointment deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Appointment not found"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error"
     *     )
     * )
     */
    public function destroy(int $id): JSONResponse
    {
        $this->appointmentsService->deleteAppointment($id);

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
