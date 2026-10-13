<?php
header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');

$target = 'https://agentai.web.id/api/wedding/wishes.php?event=fakhira-wafi';
$body = false;
$httpCode = 0;
$error = '';

if (function_exists('curl_init')) {
    $ch = curl_init($target);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_TIMEOUT => 15,
        CURLOPT_HTTPGET => true,
        CURLOPT_HTTPHEADER => ['Accept: application/json'],
    ]);
    $body = curl_exec($ch);
    $error = curl_error($ch);
    $httpCode = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
} else {
    $context = stream_context_create([
        'http' => [
            'method' => 'GET',
            'timeout' => 15,
            'header' => "Accept: application/json\r\n",
        ]
    ]);
    $body = @file_get_contents($target, false, $context);
    if (isset($http_response_header) && preg_match('/\s(\d{3})\s/', $http_response_header[0], $m)) {
        $httpCode = (int)$m[1];
    }
    if ($body === false) $error = 'Server tidak dapat menghubungi AgentAI API.';
}

if ($body !== false && $httpCode >= 200 && $httpCode < 300) {
    $json = json_decode($body, true);
    echo json_encode([
        'success' => true,
        'message' => 'Wedding frontend + PHP proxy + AgentAI API terhubung.',
        'agentai_status' => $httpCode,
        'agentai_response' => is_array($json) ? $json : null
    ]);
    exit;
}

http_response_code(502);
echo json_encode([
    'success' => false,
    'message' => 'Frontend PHP aktif, tetapi server wedding gagal menghubungi AgentAI API.',
    'agentai_status' => $httpCode,
    'detail' => $error
]);
