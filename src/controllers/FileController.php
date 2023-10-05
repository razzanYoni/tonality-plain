<?php

namespace controllers;

use bases\BaseController;
use exceptions\FileTooLargeException;
use exceptions\InvalidFileFormatException;
use RuntimeException;

class FileController extends BaseController
{
    // TODO: Revise
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