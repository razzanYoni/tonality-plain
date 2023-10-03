<?php

// URL
define('BASE_URL', 'http://localhost:8080/public');
define('STORAGE_URL', 'http://localhost:8080/storage');

// Database
define('HOST', $_ENV['DB_HOST']);
define('USER', $_ENV['MYSQL_USER']);
define('PASSWORD', $_ENV['MYSQL_PASSWORD']);
define('DATABASE', $_ENV['MYSQL_DATABASE']);
define('PORT', $_ENV['MYSQL_PORT']);
define('ROWS_PER_PAGE', 10); // Application Logic

// File
// define("ROOT_DIR", __DIR__ . "/");
define('FILE_UPLOAD_FOLDER', 'storage/');
define('MAX_SIZE', 10 * 1024 * 1024); //10MB

// Bcrypt
define('BCRYPT_COST', 12);

// Session
define('COOKIES_LIFETIME', 24 * 60 * 60);
define('SESSION_EXPIRATION_TIME', 24 * 60 * 60);
define('SESSION_REGENERATION_TIME', 30 * 60);

// Debounce
define('DEBOUNCE_TIMEOUT', 300);