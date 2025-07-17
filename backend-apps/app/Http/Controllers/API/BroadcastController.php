<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Jobs\BroadcastMessageJob;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class BroadcastController extends Controller
{
    /**
     * Send broadcast message using queue (asynchronous)
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function sendMessage(Request $request): JsonResponse
    {
        try {
            // Validate request
            $request->validate([
                'message' => 'required|string|max:1000',
            ]);

            Log::info('Broadcast message request received:', $request->all());

            $message = $request->input('message');

            // Dispatch job to queue (asynchronous)
            BroadcastMessageJob::dispatch($message);

            Log::info('Broadcast message job dispatched to queue successfully');

            return response()->json([
                'success' => true,
                'message' => 'Broadcast message has been queued and will be sent to all users.',
                'data' => [
                    'broadcast_message' => $message,
                    'timestamp' => now(),
                    'status' => 'queued'
                ]
            ], 200);

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation failed for broadcast message:', $e->errors());
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            Log::error('Failed to dispatch broadcast message job:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Failed to queue broadcast message: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Send broadcast message using queue (asynchronous) - Optimized
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function sendMessageNow(Request $request): JsonResponse
    {
        try {
            // Validate request first
            $validated = $request->validate([
                'message' => 'required|string|max:1000',
            ]);

            $message = $validated['message'];

            Log::info('Broadcast message request received', [
                'message_length' => strlen($message),
                'timestamp' => now()
            ]);

            // Dispatch job to queue immediately (asynchronous)
            BroadcastMessageJob::dispatch($message);

            Log::info('Broadcast message job dispatched to queue successfully');

            // Return response immediately without waiting
            return response()->json([
                'success' => true,
                'message' => 'Broadcast message has been queued successfully.',
                'data' => [
                    'broadcast_message' => substr($message, 0, 100) . (strlen($message) > 100 ? '...' : ''),
                    'timestamp' => now()->toISOString(),
                    'status' => 'queued'
                ]
            ], 200);

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation failed for broadcast message', $e->errors());
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            Log::error('Failed to dispatch broadcast message job', [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to queue broadcast message: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Test endpoint to check if broadcast controller is working
     *
     * @return JsonResponse
     */
    public function test(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => 'Broadcast controller is working',
            'timestamp' => now(),
            'php_version' => PHP_VERSION,
            'laravel_version' => app()->version()
        ], 200);
    }

    /**
     * Get queue status and statistics
     *
     * @return JsonResponse
     */
    public function getQueueStatus(): JsonResponse
    {
        try {
            // Get queue statistics
            $pendingJobs = DB::table('jobs')->count();
            $failedJobs = DB::table('failed_jobs')->count();
            
            return response()->json([
                'success' => true,
                'data' => [
                    'queue_status' => $pendingJobs > 0 ? 'processing' : 'idle',
                    'pending_jobs' => $pendingJobs,
                    'failed_jobs' => $failedJobs,
                    'timestamp' => now()
                ]
            ], 200);

        } catch (\Exception $e) {
            Log::error('Failed to get queue status:', [
                'error' => $e->getMessage()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Failed to get queue status: ' . $e->getMessage()
            ], 500);
        }
    }
    
}