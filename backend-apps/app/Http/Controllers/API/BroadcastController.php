<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Jobs\BroadcastMessageJob;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class BroadcastController extends Controller
{
    

    /**
     * Send broadcast message immediately (for testing)
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function sendMessageNow(Request $request): JsonResponse
    {
        try {
            // Validate request
            $request->validate([
                'message' => 'required|string|max:1000',
            ]);

            Log::info($request->all());

            $message = $request->input('message');

            // Execute job immediately
            $job = new BroadcastMessageJob($message);
            $job->handle();

            return response()->json([
                'success' => true,
                'message' => 'Broadcast message has been sent to all users immediately.',
                'data' => [
                    'broadcast_message' => $message,
                    'timestamp' => now()
                ]
            ], 200);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to send broadcast message: ' . $e->getMessage()
            ], 500);
        }
    }
    
}
