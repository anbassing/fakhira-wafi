<?php
require_once __DIR__ . '/proxy.php';

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    agentai_proxy('wishes.php', 'GET');
    exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    agentai_proxy('wishes.php', 'POST');
    exit;
}
header('Content-Type: application/json; charset=utf-8');
http_response_code(405);
echo json_encode(['success'=>false,'message'=>'Method not allowed']);
