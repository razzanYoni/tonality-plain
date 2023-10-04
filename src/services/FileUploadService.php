<?php

namespace services;

use bases\BaseService;
use exceptions\FileTooLargeException;
use exceptions\InvalidFileFormatException;
use RuntimeException;

class FileUploadService extends BaseService
{
    public function upload($file): string
    {
        if ($file['size'] > MAX_SIZE) {
            throw new FileTooLargeException();
        }

        $fileExtension = pathinfo(($file['name']), PATHINFO_EXTENSION);

        if ($fileExtension === 'mp3') {
            $relativePath = FILE_UPLOAD_FOLDER . 'songs/' . '-' . basename($file['name']);
        } else if ($fileExtension === 'png' || $fileExtension === 'jpg' || $fileExtension === 'jpeg') {
            $relativePath = FILE_UPLOAD_FOLDER . 'images/' . '-' . basename($file['name']);
        } else {
            throw new InvalidFileFormatException();
        }

        $targetPath = ROOT_DIR . $relativePath;

        if (move_uploaded_file($file['temp_name'], $targetPath)) {
            return $relativePath;
        } else {
            throw new RuntimeException('Failed to move the uploaded file');
        }
    }
}