<?php

// URL
const BASE_URL = 'http://localhost:8080/public';
const STORAGE_URL = 'http://localhost:8080/storage';

// Database
define('HOST', $_ENV['DB_HOST']);
define('USER', $_ENV['MYSQL_USER']);
define('PASSWORD', $_ENV['MYSQL_PASSWORD']);
define('DATABASE', $_ENV['MYSQL_DATABASE']);
define('PORT', $_ENV['MYSQL_PORT']);
const ROWS_PER_PAGE = 10; // Application Logic

// File
const STORAGE_FOLDER = 'storage';
const MAX_SIZE = 10 * 1024 * 1024; //10MB

// Debounce
const DEBOUNCE_TIMEOUT = 300; // 300ms