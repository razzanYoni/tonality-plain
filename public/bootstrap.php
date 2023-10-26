<?php
//session_start();

require_once ROOT_DIR . "src/utils/DotEnv.php";
use utils\DotEnv;
$envLoader = new DotEnv(ROOT_DIR . '/.env');

require_once ROOT_DIR . "src/config/config.php";

