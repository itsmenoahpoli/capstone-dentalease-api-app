<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\{Request, Response, JSONResponse};
use App\Http\Requests\ContactUs\{StoreContactUsRequest, UpdateContactUsRequest};
use App\Http\Resources\ContactUsResource;
use App\Services\ContactUsService;

/**
 * @OA\Schema(
 *     schema="ContactUs",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="John Doe"),
 *     @OA\Property(property="email", type="string", format="email", example="john.doe@example.com"),
 *     @OA\Property(property="phone", type="string", nullable=true, example="+1234567890"),
 *     @OA\Property(property="subject", type="string", example="General Inquiry"),
 *     @OA\Property(property="message", type="string", example="I would like to know more about your services."),
 *     @OA\Property(property="status", type="string", enum={"pending","read","replied","closed"}, example="pending"),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2025-07-31T09:10:00.000000Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-07-31T09:10:00.000000Z")
 * )
 */
class ContactUsController extends Controller
{
    public function __construct(
        private ContactUsService $contactUsService
    ) {}

    /**
     * @OA\Get(
     *     path="/contact-us",
     *     tags={"Contact Us"},
     *     summary="Get all contact us entries",
     *     description="Retrieve a list of all contact us entries",
     *     @OA\Response(
     *         response=200,
     *         description="List of contact us entries",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/ContactUs"))
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
        $contactUs = $this->contactUsService->getAllContactUs();

        return response()->json(ContactUsResource::collection($contactUs), Response::HTTP_OK);
    }

    /**
     * @OA\Get(
     *     path="/contact-us/{id}",
     *     tags={"Contact Us"},
     *     summary="Get a specific contact us entry",
     *     description="Retrieve a specific contact us entry by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer", minimum=1),
     *         example=1
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Contact us entry details",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", ref="#/components/schemas/ContactUs")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Contact us entry not found"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error"
     *     )
     * )
     */
    public function show(int $id): JSONResponse
    {
        $contactUs = $this->contactUsService->getContactUsById($id);

        return response()->json(new ContactUsResource($contactUs), Response::HTTP_OK);
    }

    /**
     * @OA\Post(
     *     path="/contact-us",
     *     tags={"Contact Us"},
     *     summary="Create a new contact us entry",
     *     description="Create a new contact us entry",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name","email","subject","message"},
     *             @OA\Property(property="name", type="string", example="John Doe"),
     *             @OA\Property(property="email", type="string", format="email", example="john.doe@example.com"),
     *             @OA\Property(property="phone", type="string", nullable=true, example="+1234567890"),
     *             @OA\Property(property="subject", type="string", example="General Inquiry"),
     *             @OA\Property(property="message", type="string", example="I would like to know more about your services."),
     *             @OA\Property(property="status", type="string", enum={"pending","read","replied","closed"}, example="pending")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Contact us entry created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", ref="#/components/schemas/ContactUs")
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
    public function store(StoreContactUsRequest $request): JSONResponse
    {
        $contactUs = $this->contactUsService->createContactUs($request->validated());

        return response()->json(new ContactUsResource($contactUs), Response::HTTP_CREATED);
    }

    /**
     * @OA\Put(
     *     path="/contact-us/{id}",
     *     tags={"Contact Us"},
     *     summary="Update a contact us entry",
     *     description="Update an existing contact us entry",
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
     *             @OA\Property(property="phone", type="string", nullable=true, example="+1234567890"),
     *             @OA\Property(property="subject", type="string", example="General Inquiry"),
     *             @OA\Property(property="message", type="string", example="I would like to know more about your services."),
     *             @OA\Property(property="status", type="string", enum={"pending","read","replied","closed"}, example="read")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Contact us entry updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", ref="#/components/schemas/ContactUs")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Contact us entry not found"
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
    public function update(UpdateContactUsRequest $request, int $id): JSONResponse
    {
        $contactUs = $this->contactUsService->updateContactUs($id, $request->validated());

        return response()->json(new ContactUsResource($contactUs), Response::HTTP_OK);
    }

    /**
     * @OA\Delete(
     *     path="/contact-us/{id}",
     *     tags={"Contact Us"},
     *     summary="Delete a contact us entry",
     *     description="Delete a contact us entry",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer", minimum=1),
     *         example=1
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Contact us entry deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Contact us entry deleted successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Contact us entry not found"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error"
     *     )
     * )
     */
    public function destroy(int $id): JSONResponse
    {
        $this->contactUsService->deleteContactUs($id);

        return response()->json(['message' => 'Contact us entry deleted successfully'], Response::HTTP_OK);
    }
}
