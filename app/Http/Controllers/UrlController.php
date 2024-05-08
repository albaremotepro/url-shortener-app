<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Models\Url;
use App\Services\GoogleSafeBrowsingService;

class UrlController extends Controller
{
    public function index()
    {
        return Inertia::render('UrlForm', [
            'urls' => Url::latest()->get(),
            'domain' => config('app.url')
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'original_url' => 'required|url'
        ]);

        // Check URL safety
        $safeBrowsingService = new GoogleSafeBrowsingService();
        if (!$safeBrowsingService->checkUrl($request->original_url)) {
            return redirect()->back()
                ->with('error', 'URL is not safe according to Google Safe Browsing.')
                ->withErrors(['original_url' => 'This URL has been flagged as unsafe.'])
                ->withInput();
        }

        $existingUrl = Url::where('original_url', $request->original_url)->first();

        if (!$existingUrl) {
            $hash = Str::random(6);
            while (Url::where('short_url', $hash)->exists()) {
                $hash = Str::random(6);
            }

            $url = Url::create([
                'original_url' => $request->original_url,
                'short_url' => $hash
            ]);
        } else {
            $url = $existingUrl;
        }

        return redirect()->back()->with('success', 'URL shortened successfully!');
    }

    public function redirect($hash)
    {
        $url = Url::where('short_url', $hash)->firstOrFail();
        return redirect($url->original_url);
    }
}
