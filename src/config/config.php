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

// Bcrypt
const BCRYPT_COST = 12;

// Session
const COOKIES_LIFETIME = 24 * 60 * 60;
const SESSION_EXPIRATION_TIME = 24 * 60 * 60;
const SESSION_REGENERATION_TIME = 30 * 60;

// Debounce
const DEBOUNCE_TIMEOUT = 300;