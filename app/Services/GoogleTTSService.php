<?php

namespace App\Services;

use Google\Cloud\TextToSpeech\V1\AudioConfig;
use Google\Cloud\TextToSpeech\V1\AudioEncoding;
use Google\Cloud\TextToSpeech\V1\Client\TextToSpeechClient;
use Google\Cloud\TextToSpeech\V1\SynthesisInput;
use Google\Cloud\TextToSpeech\V1\SynthesizeSpeechRequest;
use Google\Cloud\TextToSpeech\V1\VoiceSelectionParams;
use Illuminate\Support\Facades\Log;

class GoogleTTSService
{
    protected $client;
    protected $config;

    public function __construct()
    {
        $this->config = config('services.google.tts');
        
        $options = [];
        if ($this->config['credentials'] && file_exists(base_path($this->config['credentials']))) {
            $options['credentials'] = base_path($this->config['credentials']);
        }

        $this->client = new TextToSpeechClient($options);
    }

    /**
     * Synthesize text to audio.
     *
     * @param string $text
     * @return string|null Audio content in MP3 format
     */
    public function synthesize(string $text)
    {
        try {
            $input = (new SynthesisInput())
                ->setText($text);

            $voice = (new VoiceSelectionParams())
                ->setLanguageCode($this->config['language_code'])
                ->setName($this->config['voice']);

            $audioConfig = (new AudioConfig())
                ->setAudioEncoding(AudioEncoding::MP3)
                ->setSpeakingRate($this->config['speaking_rate'])
                ->setPitch($this->config['pitch']);

            $request = (new SynthesizeSpeechRequest())
                ->setInput($input)
                ->setVoice($voice)
                ->setAudioConfig($audioConfig);

            $response = $this->client->synthesizeSpeech($request);

            return $response->getAudioContent();
        } catch (\Exception $e) {
            Log::error('Google TTS Error: ' . $e->getMessage());
            return null;
        }
    }
}
