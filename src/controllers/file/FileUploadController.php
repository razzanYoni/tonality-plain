<?php

namespace controllers\file;

use bases\BaseController;
use bases\BaseService;
use exceptions\FileTooLargeException;
use exceptions\InvalidFileFormatException;
use RuntimeException;
use services\FileUploadService;

class FileUploadController extends BaseController
{
    /* @var FileUploadService $service */
    protected BaseService $service;

    public static function getInstance($service): FileUploadController
    {
        if (!isset(self::$instance)) {
            self::$instance = new static(FileUploadService::getInstance());
        }
        return self::$instance;
    }

    public function post($urlParameters): void
    {
        $uploadedFilePath = null;

        try {
            $uploadedFilePath = $this->service->upload($_FILES['file']);
        } catch (FileTooLargeException|InvalidFileFormatException|RuntimeException $e) {
            echo 'Error: ' . $e->getMessage();
        }

        http_response_code(($uploadedFilePath != null) ? 200 : 500);
        echo json_encode(array(
            'uploaded_file_path' => ($uploadedFilePath != null) ? $uploadedFilePath : null,
            'message' => ($uploadedFilePath != null) ? 'File upload successful' : 'File upload unsuccessful'
        ));
    }
}