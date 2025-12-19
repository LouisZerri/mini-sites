<?php

namespace App\Http\Controllers;

use App\Models\Agent;

class SitemapController extends Controller
{
    public function index()
    {
        $agents = Agent::where('actif', true)->get();

        return response()->view('sitemap', compact('agents'))
            ->header('Content-Type', 'application/xml');
    }
}