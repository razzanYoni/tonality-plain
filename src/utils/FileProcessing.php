<?php

namespace utils;

class FileProcessing
{
    private static FileProcessing $instance;

    public static function getInstance(): FileProcessing
    {
        if (!isset(self::$instance)) {
            self::$instance = new FileProcessing();
        }
        return self::$instance;
    }

    /**
     * Generates unique filenames (for audio and cover image)
     * and move them into /storage.
     * @return string|false filename if the file move is successful, false otherwise
     */
    public function processFile(): string|false
    {
        // Get the uploaded file and its properties
        $uploadedFile = $_FILES['cover_filename'] ?? $_FILES['audio_filename'];
        $originalFilename = $uploadedFile['name'];
        $temporaryLocation = $uploadedFile['tmp_name'];

        if ($originalFilename === null) {
            return 'default-cover.jpg';
        }

        // Generate a unique filename to avoid collision
        $uniqueFilename = $this->generateUniqueFilename($originalFilename);

        if (move_uploaded_file($temporaryLocation, STORAGE_FOLDER . '/' . $uniqueFilename)) {
            return $uniqueFilename;
        } else {
            return false;
        }
    }

    private function generateUniqueFilename(string $originalFilename): string
    {
        $extension = pathinfo($originalFilename, PATHINFO_EXTENSION);
        return uniqid('', true) . '.' . $extension;
    }
}