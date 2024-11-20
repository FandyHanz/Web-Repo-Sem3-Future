<?php
$headers = apache_request_headers();
if (isset($headers['Csrf-Token'])) {
    if ($headers['Csrf-Token'] !== $_SESSION['csrf_token']) {
        exit(json_encode(['error' => 'Wrong CSRF token.']));
    }
} else {
    exit(json_encode(['error' => 'No CSRF token.']));
}