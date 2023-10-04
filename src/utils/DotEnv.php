<?php

namespace utils;

use ErrorException;


class DotEnv
{
    private $path;

    /**
     * @throws ErrorException
     */
    public function __construct(string $path = "")
    {
        if (empty($path)) {
            throw new ErrorException(".env file path is missing");
        }

        if (!file_exists($path)) {
            throw new ErrorException(sprintf('%s does not exist', $path));
        }

        $this->path = $path;
        $this->load();
    }

    public function load()
    {
        $lines = file($this->path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        foreach ($lines as $line) {

            if (strpos(trim($line), '#') === 0) {
                continue;
            }

            list($name, $value) = explode('=', $line, 2);
            $name = trim($name);
            $value = trim($value);

            if (!array_key_exists($name, $_SERVER) && !array_key_exists($name, $_ENV)) {
                putenv(sprintf('%s=%s', $name, $value));
                $_ENV[$name] = $value;
                $_SERVER[$name] = $value;
            }
        }
    }
}