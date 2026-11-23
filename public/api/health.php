<?php

declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/../../app/config/database.php';

echo json_encode([
    'success' => true,
    'message' => 'PHP backend connected to MySQL successfully.',
    'database' => 'connected'
]);
