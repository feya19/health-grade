<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ChatStreamController extends Controller
{
    /**
     * Get LLM configuration
     */
    protected function getLlmConfig(): array
    {
        return [
            'endpoint' => config('app.llm_model.endpoint'),
            'model' => config('app.llm_model.default'),
            'api_key' => config('app.llm_model.api_key'),
        ];
    }

    /**
     * Streaming response for chat (real-time typing effect)
     */
    public function stream(Request $request)
    {
        $messages = $request->input('messages', []);
        $config = $this->getLlmConfig();

        return new StreamedResponse(function () use ($config, $messages) {
            if (ob_get_level()) {
                ob_end_clean();
            }
            
            $response = Http::withOptions([
                'stream' => true,
                'timeout' => 120,
            ])->post($config['endpoint'] . 'chat/completions', [
                'model' => $config['model'],
                'messages' => $messages,
                'stream' => true,
            ]);

            $stream = $response->getBody();
            
            while (!$stream->eof()) {
                $chunk = $stream->read(8192);
                
                if ($chunk === false || $chunk === '') {
                    continue;
                }
                
                echo $chunk;
                
                if (function_exists('fastcgi_finish_request')) {
                    fastcgi_finish_request();
                } else {
                    if (ob_get_level() > 0) {
                        ob_flush();
                    }
                    flush();
                }
                
                usleep(1000);
            }
        }, 200, [
            'Content-Type' => 'text/event-stream',
            'Cache-Control' => 'no-cache',
            'Connection' => 'keep-alive',
            'X-Accel-Buffering' => 'no',
        ]);
    }

    /**
     * Single non-streaming response (for AI Vision extraction, quick queries)
     */
    public function response(Request $request)
    {
        $messages = $request->input('messages', []);
        $config = $this->getLlmConfig();

        try {
            $response = Http::timeout(60)
                ->post($config['endpoint'] . 'chat/completions', [
                    'model' => $config['model'],
                    'messages' => $messages,
                    'stream' => false,
                ]);

            if ($response->failed()) {
                return response()->json([
                    'error' => true,
                    'message' => 'AI service error: ' . $response->status()
                ], 500);
            }

            $data = $response->json();
            $content = $data['choices'][0]['message']['content'] ?? null;

            return response()->json([
                'success' => true,
                'content' => $content,
                'usage' => $data['usage'] ?? null,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => 'Failed to get AI response: ' . $e->getMessage()
            ], 500);
        }
    }
}
