<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\{Request, Response, JSONResponse};
use App\Http\Requests\ContentData\{StoreContentDataRequest, UpdateContentDataRequest};
use App\Http\Resources\ContentDataResource;
use App\Services\ContentDataService;

/**
 * @OA\Schema(
 *     schema="ContentData",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="category", type="string", example="clinic_information"),
 *     @OA\Property(property="category_display", type="string", example="Clinic Information"),
 *     @OA\Property(property="title", type="string", example="Welcome to DentalEase"),
 *     @OA\Property(property="content", type="string", example="We provide comprehensive dental care services..."),
 *     @OA\Property(property="metadata", type="object", example={"contact_email": "info@dentalease.com"}),
 *     @OA\Property(property="is_active", type="boolean", example=true),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2025-07-31T09:10:00.000000Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-07-31T09:10:00.000000Z")
 * )
 */
class ContentDataController extends Controller
{
    public function __construct(
        private ContentDataService $contentDataService
    ) {}

    /**
     * @OA\Get(
     *     path="/content",
     *     tags={"Content Management"},
     *     summary="Get all content",
     *     description="Retrieve a list of all CMS content",
     *     @OA\Response(
     *         response=200,
     *         description="List of content",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/ContentData"))
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
        $content = $this->contentDataService->getAllContent();

        return response()->json(ContentDataResource::collection($content), Response::HTTP_OK);
    }

    /**
     * @OA\Get(
     *     path="/content/{id}",
     *     tags={"Content Management"},
     *     summary="Get a specific content",
     *     description="Retrieve a specific CMS content by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer", minimum=1),
     *         example=1
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Content details",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", ref="#/components/schemas/ContentData")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Content not found"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error"
     *     )
     * )
     */
    public function show(int $id): JSONResponse
    {
        $content = $this->contentDataService->getContentById($id);

        return response()->json(new ContentDataResource($content), Response::HTTP_OK);
    }

    /**
     * @OA\Get(
     *     path="/content/category/{category}",
     *     tags={"Content Management"},
     *     summary="Get content by category",
     *     description="Retrieve CMS content by category",
     *     @OA\Parameter(
     *         name="category",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string", enum={"clinic_information","clinic_announcements","latest_developments","owner_information","our_team"}, example="clinic_information")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Content details",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", ref="#/components/schemas/ContentData")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Content not found"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error"
     *     )
     * )
     */
    public function showByCategory(string $category): JSONResponse
    {
        $content = $this->contentDataService->getContentByCategory($category);

        if (!$content) {
            return response()->json(['message' => 'Content not found for this category'], Response::HTTP_NOT_FOUND);
        }

        return response()->json(new ContentDataResource($content), Response::HTTP_OK);
    }

    /**
     * @OA\Post(
     *     path="/content",
     *     tags={"Content Management"},
     *     summary="Create new content",
     *     description="Create a new CMS content entry",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"category","title","content"},
     *             @OA\Property(property="category", type="string", enum={"clinic_information","clinic_announcements","latest_developments","owner_information","our_team"}, example="clinic_information"),
     *             @OA\Property(property="title", type="string", maxLength=255, example="Welcome to DentalEase"),
     *             @OA\Property(property="content", type="string", example="We provide comprehensive dental care services..."),
     *             @OA\Property(property="metadata", type="object", example={"contact_email": "info@dentalease.com"}),
     *             @OA\Property(property="is_active", type="boolean", example=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Content created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", ref="#/components/schemas/ContentData")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Validation error"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Category already exists"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error"
     *     )
     * )
     */
    public function store(StoreContentDataRequest $request): JSONResponse
    {
        $content = $this->contentDataService->createContent($request->validated());

        return response()->json(new ContentDataResource($content), Response::HTTP_CREATED);
    }

    /**
     * @OA\Put(
     *     path="/content/{id}",
     *     tags={"Content Management"},
     *     summary="Update content",
     *     description="Update an existing CMS content entry",
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
     *             @OA\Property(property="category", type="string", enum={"clinic_information","clinic_announcements","latest_developments","owner_information","our_team"}, example="clinic_information"),
     *             @OA\Property(property="title", type="string", maxLength=255, example="Welcome to DentalEase"),
     *             @OA\Property(property="content", type="string", example="We provide comprehensive dental care services..."),
     *             @OA\Property(property="metadata", type="object", example={"contact_email": "info@dentalease.com"}),
     *             @OA\Property(property="is_active", type="boolean", example=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Content updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", ref="#/components/schemas/ContentData")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Validation error"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Content not found"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Category already exists"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error"
     *     )
     * )
     */
    public function update(UpdateContentDataRequest $request, int $id): JSONResponse
    {
        $content = $this->contentDataService->updateContent($id, $request->validated());

        return response()->json(new ContentDataResource($content), Response::HTTP_OK);
    }

    /**
     * @OA\Delete(
     *     path="/content/{id}",
     *     tags={"Content Management"},
     *     summary="Delete content",
     *     description="Delete a CMS content entry",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer", minimum=1),
     *         example=1
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Content deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Content not found"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error"
     *     )
     * )
     */
    public function destroy(int $id): JSONResponse
    {
        $this->contentDataService->deleteContent($id);

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * @OA\Get(
     *     path="/content/active",
     *     tags={"Content Management"},
     *     summary="Get active content",
     *     description="Retrieve all active CMS content",
     *     @OA\Response(
     *         response=200,
     *         description="List of active content",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/ContentData"))
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error"
     *     )
     * )
     */
    public function active(): JSONResponse
    {
        $content = $this->contentDataService->getActiveContent();

        return response()->json(ContentDataResource::collection($content), Response::HTTP_OK);
    }
}
