<?php

namespace repositories;

use cores\Application,
    bases\BaseRepository,
    PDOException;

class AlbumRepository extends BaseRepository
{
    protected static BaseRepository $instance;
    public static function tableName(): string
    {
        return 'albums';
    }

    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new static();
        }
        return self::$instance;
    }

    public function getAlbumById($album_id)
    {
        return $this->findOne(where : ["album_id" => $album_id]);
    }

    public function getAlbumByName($album_name)
    {
        return $this->findAll(where : ["album_name" => $album_name]);
    }

    public function getAlbumByArtist($artist): bool|array
    {
        return $this->findAll(where: ["artist" => $artist]);
    }

    public function getAlbumByGenre($genre): bool|array
    {
        return $this->findAll(where: ["genre" => $genre]);
    }

    public function getAlbumGenres(): bool|array
    {
        $query = "SELECT DISTINCT genre FROM albums";
        $stmt = Application::$app->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getSongsFromAlbum($album_id): bool|array
    {
        try {
            $query = "SELECT * FROM songs WHERE album_id = :album_id";
            $stmt = Application::$app->db->prepare($query);

            $stmt->bindParam(':album_id', $album_id);

            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return [];
        }
    }
}