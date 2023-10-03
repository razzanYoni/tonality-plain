<?php

namespace repositories;

use bases\BaseRepository;

class AlbumRepository extends BaseRepository {
    protected static $instance;
    protected $table = "albums";

    private function __construct() {
        parent::__construct();
    }

    public static function getInstance() {
        if (!isset(self::$instance)) {
            self::$instance = new AlbumRepository();
        }
        return self::$instance;
    }

    public function getById($album_id) {
        return $this->getOne(["album_id" => $album_id]);
    }

    public function getByName($album_name) {
        return $this->getOne(["album_name" => $album_name]);
    }

    public function getByArtist($artist) {
        return $this->getAll(where: ["artist" => $artist]);
    }

    public function getByGenre($genre) {
        return $this->getAll(
            where: ["genre" => $genre]
        );
    }

    public function getGenres() {
        $query = "SELECT DISTINCT genre FROM albums";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getSongsFromAlbum($album_id) {
        try {
            $query = "SELECT * FROM songs WHERE album_id = :album_id";
            $stmt = $this->pdo->prepare($query);

            $stmt->bindParam(':album_id', $album_id);

            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return [];
        }
    }
}
