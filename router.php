<?php

// --- Security Headers ---
// header('X-Content-Type-Options: nosniff');                      // Prevent MIME sniffing
// header('X-Frame-Options: DENY');                                // Prevent clickjacking
// header('X-XSS-Protection: 1; mode=block');                      // Basic XSS protection (legacy)
// header('Referrer-Policy: no-referrer');                         // Hide referrer info
// header('Permissions-Policy: geolocation=(), microphone=()');    // Limit browser features
// header('Strict-Transport-Security: max-age=63072000; includeSubDomains; preload'); // Force HTTPS
// header('Cache-Control: no-store, no-cache, must-revalidate');   // Prevent caching
// header('Pragma: no-cache');
header_remove('X-Powered-By');                                  // Remove "X-Powered-By: PHP"

// API route
$requestUri = $_SERVER['REQUEST_URI'];

if (str_starts_with($requestUri, '/api/todos')) {
    header('Content-Type: application/json');
    echo json_encode([
        ['id' => 1, 'title' => 'Buy milk', 'completed' => false],
        ['id' => 2, 'title' => 'Clean room', 'completed' => true],
    ]);
    exit;
}

// Serve static files
$filePath = __DIR__ . parse_url($requestUri, PHP_URL_PATH);
if (file_exists($filePath) && !is_dir($filePath)) {
    return false; // Let web server serve static files
}

// SPA fallback
readfile(__DIR__ . '/index.html');
