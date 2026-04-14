<?php

namespace App\Services;

use Google\Cloud\Speech\V1\SpeechClient;
use Google\Cloud\Speech\V1\RecognitionConfig;
use Google\Cloud\Speech\V1\RecognitionAudio;

class GoogleSpeechService
{
    public static function transcribe(string $audioPath): string
    {
        // ADC otomatis
        $speech = new SpeechClient();

        $audioContent = file_get_contents(
            storage_path('app/public/' . $audioPath)
        );

        $audio = new RecognitionAudio([
            'content' => $audioContent
        ]);

        $config = new RecognitionConfig([
            'encoding' => RecognitionConfig\AudioEncoding::LINEAR16,
            'language_code' => 'id-ID',
            'enable_automatic_punctuation' => true,
        ]);

        $response = $speech->recognize($config, $audio);

        $text = '';
        foreach ($response->getResults() as $result) {
            $text .= $result->getAlternatives()[0]->getTranscript() . ' ';
        }

        $speech->close();

        return trim($text);
    }
}
