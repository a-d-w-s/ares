<?php

namespace ADWS\Ares;

use InvalidArgumentException;
use RuntimeException;

/**
 * Ekonomické subjekty
 *
 * Library for obtaining informace o firmě z veřejného rejstříku.
 */
class ES
{
    private string $baseUrl = 'https://ares.gov.cz/ekonomicke-subjekty-v-be/rest/ekonomicke-subjekty/';

    /**
     * Fetch data for a given IČ
     *
     * @param string $ic
     * @return array<int|string, mixed>  Returns associative array with company data
     * @throws InvalidArgumentException|RuntimeException
     */
    public function fetch(string $ic): array
    {
        $ic = preg_replace('/\D/', '', $ic) ?? '';

        if (strlen($ic) > 8) {
            throw new InvalidArgumentException("IČO nesmí mít více než 8 číslic, '$ic' je příliš dlouhé.");
        }

        if (strlen($ic) < 8) {
            $ic = str_pad($ic, 8, '0', STR_PAD_LEFT);
        }

        $url = $this->baseUrl . urlencode($ic);

        $ch = curl_init($url);
        if ($ch === false) {
            throw new RuntimeException("Nepodařilo se inicializovat cURL pro URL: $url");
        }

        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_TIMEOUT => 10,
            CURLOPT_HTTPHEADER => [
                'Accept: application/json'
            ],
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if (curl_errno($ch)) {
            $err = curl_error($ch);
            curl_close($ch);
            throw new InvalidArgumentException('cURL error: ' . $err);
        }

        curl_close($ch);

        if ($response === false) {
            throw new RuntimeException('Empty response from API.');
        }

        if ($httpCode !== 200) {
            throw new InvalidArgumentException("HTTP error: $httpCode");
        }

        $data = json_decode((string)$response, true);

        if (!is_array($data) || json_last_error() !== JSON_ERROR_NONE) {
            throw new InvalidArgumentException('JSON decode error: ' . json_last_error_msg());
        }

        return $data;
    }
}
