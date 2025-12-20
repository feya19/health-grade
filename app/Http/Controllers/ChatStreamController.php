<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ChatStreamController extends Controller
{
    public function stream(Request $request)
    {
        $messages = $request->input('messages', []);
        
        $endpoint = config('app.llm_model.endpoint');
        $model = config('app.llm_model.default');
        $apiKey = config('app.llm_model.api_key');

        return new StreamedResponse(function () use ($endpoint, $model, $apiKey, $messages) {
            // Disable output buffering for real-time streaming
            if (ob_get_level()) {
                ob_end_clean();
            }
            
            $response = Http::withOptions([
                'stream' => true,
                'timeout' => 120, // 2 minutes timeout
            ])->post($endpoint . 'chat/completions', [
                'model' => $model,
                'messages' => $messages,
                'stream' => true,
            ]);

            $stream = $response->getBody();
            $buffer = '';
            
            // Use larger buffer size to prevent data loss
            while (!$stream->eof()) {
                $chunk = $stream->read(8192); // Increased from 1024 to 8192
                
                if ($chunk === false || $chunk === '') {
                    continue;
                }
                
                // Echo the chunk immediately
                echo $chunk;
                
                // Force flush to client
                if (function_exists('fastcgi_finish_request')) {
                    fastcgi_finish_request();
                } else {
                    if (ob_get_level() > 0) {
                        ob_flush();
                    }
                    flush();
                }
                
                // Small delay to prevent overwhelming the client
                usleep(1000); // 1ms
            }
        }, 200, [
            'Content-Type' => 'text/event-stream',
            'Cache-Control' => 'no-cache',
            'Connection' => 'keep-alive',
            'X-Accel-Buffering' => 'no',
        ]);
    }
}
