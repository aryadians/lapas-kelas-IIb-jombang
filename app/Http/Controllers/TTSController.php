<?php

namespace App\Http\Controllers;

use App\Services\GoogleTTSService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class TTSController extends Controller
{
    protected $ttsService;

    public function __construct(GoogleTTSService $ttsService)
    {
        $this->ttsService = $ttsService;
    }

    /**
     * Synthesize text to speech and return audio file.
     */
    public function synthesize(Request $request)
    {
        $text = $request->get('text');

        if (empty($text)) {
            return response()->json(['error' => 'Text is required'], 400);
        }

        // Cache the audio content to save quota
        $cacheKey = 'tts_' . md5($text);
        $audioContent = Cache::remember($cacheKey, now()->addDays(7), function () use ($text) {
            return $this->ttsService->synthesize($text);
        });

        if (!$audioContent) {
            return response()->json(['error' => 'Failed to synthesize speech'], 500);
        }

        return response($audioContent)
            ->header('Content-Type', 'audio/mpeg')
            ->header('Cache-Control', 'public, max-age=604800');
    }
}
