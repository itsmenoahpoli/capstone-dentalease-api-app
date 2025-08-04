<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class SwaggerController extends Controller
{
    public function index(): View
    {
        return view('swagger.index');
    }

    public function docs(): Response
    {
        // Try to read YAML file first, fallback to JSON
        $yamlPath = storage_path('api-docs/api-docs.yaml');
        $jsonPath = storage_path('api-docs/api-docs.json');

        if (file_exists($yamlPath)) {
            $content = file_get_contents($yamlPath);
            $contentType = 'application/x-yaml';
        } elseif (file_exists($jsonPath)) {
            $content = file_get_contents($jsonPath);
            $contentType = 'application/json';
        } else {
            abort(404, 'API documentation not found. Please run: php artisan l5-swagger:generate');
        }

        return response($content, 200, [
            'Content-Type' => $contentType,
        ]);
    }
}
