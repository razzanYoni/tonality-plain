<?php

namespace services;

use bases\BaseService;
use models\AlbumModel;
use repositories\AlbumRepository;
use PDO, exceptions;

class AlbumService extends BaseService {
    protected static BaseService $instance;

    private function __construct($repository) {
        // parent::__construct();
        $this->repository = AlbumRepository::getInstance();
    }

    public static function getInstance(): AlbumService {
        if (!isset(self::$instance)) {
            self::$instance = new static(AlbumRepository::getInstance());
        }
        return self::$instance;
    }

    public function createAlbum($album_name, $release_date, $genre, $artist, $cover_url) {
        $data = [
            "album_name" => $album_name,
            "release_date" => $release_date,
            "genre" => $genre,
            "artist" => $artist,
            "cover_url" => $cover_url
        ];

        $this->repository->insert($data);
        $lastInsertId = $this->repository->getPDO()->lastInsertId();

        return $lastInsertId;
    }

    public function getAll() {
        $albumSQL = $this->repository->getAll();
        $albums = array();
        foreach ($albumSQL as $album) {
            $albums[] = new AlbumModel(
                array(
                    'album_id' => $album['album_id'],
                    "album_name" => $album['album_name'],
                    "release_date" => $album['release_date'],
                    "genre" => $album['genre'],
                    "artist" => $album['artist'],
                    "cover_url" => $album['cover_url']
                )
            );
        }
        return $albums;
    }

    public function getById($album_id) {
        $where = [
            "album_id" => $album_id
        ];

        $albumSQL = $this->repository->getOne($where);
        $album = array(
            'album_id' => $album_id,
            "album_name" => $albumSQL['album_name'],
            "release_date" => $albumSQL['release_date'],
            "genre" => $albumSQL['genre'],
            "artist" => $albumSQL['artist'],
            "cover_url" => $albumSQL['cover_url']
        );

        return $album;
    }

    public function getByUsername($album_name) {
        $where = [
            "album_name" => $album_name
        ];

        $albumSQL = $this->repository->getOne($where);
        $album = array(
            'album_id' => $albumSQL['album_id'],
            "album_name" => $album_name,
            "release_date" => $albumSQL['release_date'],
            "genre" => $albumSQL['genre'],
            "artist" => $albumSQL['artist'],
            "cover_url" => $albumSQL['cover_url']
        );

        return $album;
    }

    public function updateAlbum($album_id, $album_name, $release_date, $genre, $artist, $cover_url) {
        $data = [
            "album_name" => $album_name,
            "release_date" => $release_date,
            "genre" => $genre,
            "artist" => $artist,
            "cover_url" => $cover_url
        ];

        $where = [
            "album_id" => $album_id
        ];

        $this->repository->update($where, $data);
    }

    public function deleteAlbum($album_id) {
        $where = [
            "album_id" => $album_id
        ];

        $this->repository->delete($where);
    }
}
