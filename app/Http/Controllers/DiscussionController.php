<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

class DiscussionController extends Controller
{
    public function store(Request $request, $productId)
    {
        $request->validate([
            'content' => 'required',
        ]);

        $response = Http::post('http://localhost:8080/discussions', [
            'product_id' => (int)$productId,
            'user_id' => Auth::id(),
            'content' => $request->content
        ]);

        if (!$response->successful()) {
            return redirect()->back()->with('error', 'Failed to create discussion');
        }

        return redirect()->back()->with('success', 'Discussion created successfully');
    }

    public function reply(Request $request, $discussionId)
    {
        $request->validate([
            'content' => 'required',
        ]);

        $response = Http::post("http://localhost:8080/discussions/{$discussionId}/reply", [
            'user_id' => Auth::id(),
            'content' => $request->content
        ]);

        if (!$response->successful()) {
            return redirect()->back()->with('error', 'Failed to create reply');
        }

        return redirect()->back()->with('success', 'Reply posted successfully');
    }
}