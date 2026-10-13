<?php
header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');

function agentai_proxy(string $endpoint, string $method): void {
    $target = 'https://agentai.web.id/api/wedding/' . $endpoint;
    if (!empty($_SERVER['QUERY_STRING'])) {
        $target .= '?' . $_SERVER['QUERY_STRING'];
    }

    $body = file_get_contents('php://input');
    $response = false;
    $status = 0;
    $error = '';

    if (function_exists('curl_init')) {
        $ch = curl_init($target);
        $headers = ['Accept: application/json'];
        if ($method === 'POST') $headers[] = 'Content-Type: application/json';
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_TIMEOUT => 20,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_HTTPHEADER => $headers,
        ]);
        if ($method === 'POST') curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
        $response = curl_exec($ch);
        $error = curl_error($ch);
        $status = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
    } else {
        $headers = "Accept: application/json\r\n";
        if ($method === 'POST') $headers .= "Content-Type: application/json\r\n";
        $context = stream_context_create([
            'http' => [
                'method' => $method,
                'timeout' => 20,
                'ignore_errors' => true,
                'header' => $headers,
                'content' => $method === 'POST' ? $body : null,
            ]
        ]);
        $response = @file_get_contents($target, false, $context);
        if (isset($http_response_header) && preg_match('/\s(\d{3})\s/', $http_response_header[0], $m)) {
            $status = (int)$m[1];
        }
        if ($response === false) $error = 'Server tidak dapat menghubungi AgentAI API.';
    }

    if ($response === false) {
        http_response_code(502);
        echo json_encode(['success'=>false,'message'=>'AgentAI API connection failed','detail'=>$error]);
        return;
    }

    http_response_code($status > 0 ? $status : 502);
    echo $response;
}
