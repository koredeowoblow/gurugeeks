<?php

namespace App\Http\Controllers;
use App\Models\UserPreference;

use Illuminate\Http\Request;

class UserController extends Controller
{

    public function __construct()
    {
        // Constructor logic if needed
    }

    public function setPreferences(Request $request)
    {
        $request->validate([
            'categories' => 'required|array',
            'categories.*' => 'exists:categories,id',
        ]);

        $user = auth()->user();

        // Delete existing preferences
        UserPreference::where('user_id', $user->id)->delete();

        // Insert new preferences
        $data = [];
        foreach ($request->categories as $categoryId) {
            $data[] = [
                'user_id' => $user->id,
                'category_id' => $categoryId,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        UserPreference::insert($data);

        return response()->json(['message' => 'Preferences updated successfully.']);
    }
}
