<?php

namespace App\Http\Controllers;

use App\Models\CarShow; // Ensure the model is imported
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator; // Import Validator for validation
use Illuminate\Support\Facades\Storage; // Import Storage for file handling
use Illuminate\Support\Facades\Response; // Import Response for JSON responses

use Illuminate\Support\Facades\Auth; // Import Auth for authentication
use Illuminate\Support\Facades\Gate; // Import Gate for authorization checks    

class Admin extends Controller
{
    public function index()
    {
        try {
            $carShows = CarShow::all(); // Fetch all car show records
            return response()->json($carShows, 200); // Return as JSON with HTTP 200 status
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500); // Handle errors
        }
    }

    public function create()
    {
        return view('admin.car_shows.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'             => 'required|string|max:255',
            'picture'           => 'nullable|string|max:255',
            'organizer'         => 'nullable|string|max:255',
            'event_date'        => 'nullable|date',
            'event_date_start'  => 'nullable|date|after_or_equal:event_date',
            'event_date_end'    => 'nullable|date|after_or_equal:event_date_start',
            'location'          => 'required|string|max:255',
            'description'       => 'nullable|string',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 422);
        }
    
        try {
            // Handle image upload (if needed)
            $imagePath = null;
            if ($request->hasFile('picture')) {
                $imagePath = $request->file('picture')->store('car_shows', 'public');
            }
    
            $carShow = CarShow::create([
                'title'             => $request->title,
                'picture'           => $imagePath,
                'organizer'         => $request->organizer,
                'event_date'        => $request->event_date,
                'event_date_start'  => $request->event_date_start,
                'event_date_end'    => $request->event_date_end,
                'location'          => $request->location,
                'description'       => $request->description,
            ]);
    
            return response()->json([
                'status' => 'success',
                'message' => 'Car show created successfully',
                'data' => $carShow,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function edit(CarShow $carShow)
    {
        return view('admin.car_shows.edit', compact('carShow'));
    }

    public function update(Request $request, CarShow $carShow, $id)
    {
        $validator = Validator::make($request->all(), [
            'title'            => 'required|string|max:255',
            'picture'          => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:8192',
            'organizer'        => 'nullable|string|max:255',
            'event_date'       => 'nullable|date',
            'event_date_start' => 'nullable|date|after_or_equal:event_date',
            'event_date_end'   => 'nullable|date|after_or_equal:event_date_start',
            'location'         => 'required|string|max:255',
            'description'      => 'nullable|string',
        ]);
        

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 422);
        }
        $carShow = CarShow::findOrFail($id);
        // Handle image upload (if needed)
        try {
            $carShow->update($request->all());
            return response()->json([
                'status' => 'success',
                'message' => 'Car show updated successfully',
                'data' => $carShow,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $carShow = CarShow::findOrFail($id);
            $carShow->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Car show deleted successfully',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function getAllCarShows()
    {
        try {
            $carShows = CarShow::all();
            return response()->json($carShows, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}

