<?php
function http_request_get($url) {
    $userAgent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/115.0.0.0 Safari/537.36 NewsClientApp/1.0';

    // 1. Eksekusi menggunakan cURL jika ekstensi tersedia
    if (function_exists('curl_init')) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, $userAgent);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        $output = curl_exec($ch);
        $curlError = curl_errno($ch);
        curl_close($ch);

        // Jika request via cURL berhasil dan tidak error, kembalikan output
        if (!$curlError && $output !== false) {
            return $output;
        }
    }

    // 2. Fallback: Eksekusi menggunakan HTTP Stream Context jika cURL tidak aktif atau gagal
    $options = [
        "http" => [
            "method" => "GET",
            "header" => "User-Agent: " . $userAgent . "\r\n" .
                        "Accept: application/json\r\n",
            "timeout" => 30,
            "ignore_errors" => true // Menangkap body response meski HTTP code bernilai error (misal: 401/429)
        ],
        "ssl" => [
            "verify_peer" => false,
            "verify_peer_name" => false
        ]
    ];

    $context = stream_context_create($options);
    $output = @file_get_contents($url, false, $context);

    // 3. Tangani jika koneksi jaringan server benar-benar terputus
    if ($output === false) {
        return json_encode([
            'status' => 'error',
            'message' => 'Gagal mengambil data dari API server NewsAPI.'
        ]);
    }

    return $output;
}
?>