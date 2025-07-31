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
        $yamlContent = file_get_contents(base_path('api-docs.yaml'));

        return response($yamlContent, 200, [
            'Content-Type' => 'application/x-yaml',
        ]);
    }
}
