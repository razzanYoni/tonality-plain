<?php

class FileManager {
    private static $instance;

    private function __construct() { }

    public static function getInstance() {
        if (!isset(self::$instance)) {
            self::$instance = new FileManager();
        }
        return self::$instance;
    }

    private function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength)];
        }

        return md5($randomString);
    }

    public function uploadFile($file) {
        try {
            $ext = pathinfo(($file['name']), PATHINFO_EXTENSION);
            if ($ext === 'mp3') {
                $relativePath = FILE_UPLOAD_FOLDER . 'audios/' . $this->generateRandomString() . '-' . basename($file['name']);
            } else if ($ext === 'png' || $ext === 'jpg' || $ext === 'jpeg') {
                $relativePath = FILE_UPLOAD_FOLDER . 'images/' . $this->generateRandomString() . '-' . basename($file['name']);
            } else {
                throw new Exception('Invalid file type');
            }

            $targetFile = ROOT_DIR . $relativePath;

            if (file_exists($targetFile)) {
                throw new Exception('File already exists');
            }

            if ($file['size'] > MAX_SIZE) {
                throw new Exception('File is too large');
            }

            if (move_uploaded_file($file['tmp_name'], $targetFile)) {
                return $relativePath;
            } else {
                throw new Exception('Error uploading file');
            }
        } catch (Exception $e) {
            throw new Exception("Upload File Error: " . $e->getMessage());
        }
    }
}