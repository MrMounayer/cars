<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiTokenController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        $tokens = $user->tokens ?? [];
        return view('admin.api-tokens', [
            'tokens' => $tokens,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'token_name' => 'required|string|max:255',
        ]);
        $user = $request->user();
        $token = $user->createToken($request->token_name);
        return redirect()->back()->with('token', $token->plainTextToken);
    }

    public function destroy(Request $request, $id)
    {
        $user = $request->user();
        $user->tokens()->where('id', $id)->delete();
        return redirect()->back();
    }
}
