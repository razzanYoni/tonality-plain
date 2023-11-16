<?php

namespace controllers;

require_once ROOT_DIR . 'src/middlewares/ClientMiddleware.php';

use bases\BaseController;
use cores\Request;
use middlewares\ClientMiddleware;
use utils\FileProcessing;

class UploadFileController extends BaseController
{
    public function __construct()
    {
        $this->registerMiddleware(new ClientMiddleware(['upload']));
    }

    public function upload(Request $request)
    {
        $file = $request->getFiles()['rest-file'];

        move_uploaded_file($file['tmp_name'], STORAGE_FOLDER . '/' . $file['name']);

        $response_json = [
            'message' => 'File uploaded successfully',
            'code' => 200,
            'data' => [
                'file_name' => $file['name'],
                ]
        ];
        print_r(json_encode($response_json));
        exit;
    }
}