<?php

namespace App\Http\Controllers;

class APIController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function swagger()
    {
        return view('swagger', ['title' => 'Swagger UI']);
    }

    public function redoc()
    {
        return view('redoc', ['title' => 'Redoc']);
    }

    public function json()
    {
        $openapi = \OpenApi\scan([
            realpath(__DIR__ . "/../../Api"),
            realpath(__DIR__ . "/../../Models"),
            realpath(__DIR__),
        ]);

        return response($openapi->toJson(), 200, [
            'Content-Type' => 'application/json'
        ]);
    }
}
