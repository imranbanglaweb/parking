<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LocalizationController extends Controller
{
    public function changeLanguage(Request $request, string $language)
    {
        try {
            session(['locale' => $language]);
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            return back()->with(['message' => 'Something Wrong. Please Try Again', 'alert-type' => 'success']);
        }

        return back()->with(['message' => 'Language Successfully Changed', 'alert-type' => 'success']);
    }
}
