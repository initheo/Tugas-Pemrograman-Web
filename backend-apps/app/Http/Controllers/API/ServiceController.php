<?php

namespace App\Http\Controllers\API;

use App\Models\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            // Retrieve all services
            $services = Service::all();

            return response()->json([
                'message' => 'List of services',
                'data' => $services
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error retrieving services: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            // Validate the request data
            $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'price' => 'required|numeric|min:0',
                'service_code' => 'nullable|string|max:50',
                'duration' => 'required|string|max:50',
                'is_active' => 'boolean'
            ]);

            // Convert is_active to status for database
            $data = $request->all();
            if (isset($data['is_active'])) {
                $data['status'] = $data['is_active'] ? 'active' : 'inactive';
                unset($data['is_active']);
            } else {
                $data['status'] = 'active'; // default
            }

            // Create a new service
            $service = Service::create($data);

            return response()->json([
                'message' => 'Service created successfully',
                'data' => $service
            ], 201);

        } catch (\Exception $e) {

            return response()->json([
                'message' => 'Error creating service: ' . $e->getMessage()
            ], 500);

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Find the service by ID
        $service = Service::find($id);

        // If service not found, return 404
        if (!$service) {
            return response()->json([
                'message' => 'Service not found'
            ], 404);
        }

        // Return the service details
        return response()->json([
            'message' => 'Service details',
            'data' => $service
        ]);
    }

     

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function edit(Service $service)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            // Validate the request data
            $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'price' => 'required|numeric|min:0',
                'service_code' => 'nullable|string|max:50',
                'duration' => 'required|string|max:50',
                'is_active' => 'boolean'
            ]);

            // Find the service by ID
            $service = Service::find($id);

            if (!$service) {
                return response()->json([
                    'message' => 'Service not found'
                ], 404);
            }

            // Convert is_active to status for database
            $data = $request->all();
            if (isset($data['is_active'])) {
                $data['status'] = $data['is_active'] ? 'active' : 'inactive';
                unset($data['is_active']);
            }

            // Update the service
            $service->update($data);

            return response()->json([
                'message' => 'Service updated successfully',
                'data' => $service
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'message' => 'Error updating service: ' . $e->getMessage()
            ], 500);
            
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            // Find the service by ID
            $service = Service::find($id);

            // If service not found, return 404
            if (!$service) {
                return response()->json([
                    'message' => 'Service not found'
                ], 404);
            }

            // Delete the service
            $service->delete();

            return response()->json([
                'message' => 'Service deleted successfully'
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'message' => 'Error deleting service: ' . $e->getMessage()
            ], 500);

        }
    }


}
