<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

// Define API routes for the Car Show Management application
// API Routes for Car Show Management
Route::post('/login', function (Request $request) {
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    $user = \App\Models\User::where('email', $credentials['email'])->first();

    if (!$user || !\Illuminate\Support\Facades\Hash::check($credentials['password'], $user->password)) {
        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    // Create a new token for the user
    $token = $user->createToken('api-token')->plainTextToken;

    return response()->json([
        'user' => $user,
        'isAdmin' => $user->is_admin ?? false, // customize as needed
        'token' => $token,
        'token_type' => 'Bearer',
    ]);
});
Route::post('/register', function (Request $request) {
    $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        'password' => ['required', 'string', 'min:8'],
        'role' => ['required', 'in:user,organizer'],
        'organization' => ['nullable', 'string', 'max:255'],
    ]);

    if ($request->role === 'organizer' && !$request->organization) {
        throw ValidationException::withMessages([
            'organization' => 'Organization is required for organizers.',
        ]);
    }

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => $request->role,
        'organization' => $request->organization,
    ]);

    return response()->json(['message' => 'User registered successfully']);
});
Route::post('/car-shows', [Admin::class, 'store']);
Route::put('/car-shows/{id}', [Admin::class, 'update']);
Route::delete('/car-shows/{id}', [Admin::class, 'destroy']);
//                 'organizer'         => $request->organizer,
//                 'event_date'        => $request->event_date,
//                 'event_date_start'  => $request->event_date_start,
//                 'event_date_end'    => $request->event_date_end,
//                 'location'          => $request->location,
//                 'description'       => $request->description,
//             ]);

Route::get('/car-shows', [Admin::class, 'index']); // Ensure this returns all car show data
