<?php

namespace App\Http\Controllers;

use App\Models\Discussion;
use App\Models\Reply;
use Illuminate\Http\Request;

class DiscussionController extends Controller
{
    public function store(Request $request, $productId)
    {
        $request->validate([
            'content' => 'required',
        ]);

        Discussion::create([
            'product_id' => $productId,
            'user_id' => auth()->id(),
            'content' => $request->content,
        ]);

        return redirect()->back();
    }

    public function reply(Request $request, $discussionId)
    {
        $request->validate([
            'content' => 'required',
        ]);

        Reply::create([
            'discussion_id' => $discussionId,
            'user_id' => auth()->id(),
            'content' => $request->content,
        ]);

        return redirect()->back();
    }
}