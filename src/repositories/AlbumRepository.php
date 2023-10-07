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

    public static function attributes(): array
    {
        return [
            'album_name',
            'release_date',
            'genre',
            'artist',
            'cover_url'
        ];
    }

    public static function primaryKey(): string
    {
        return 'album_id';
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
        return $this->findOne(["album_id" => $album_id]);
    }

    public function getAlbumByName($album_name)
    {
        return $this->findAll(where: ["album_name" => $album_name]);
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

    public function getAlbumDuration($album_id): bool|int
    {
        try {
            $query = "SELECT SUM(duration) AS total_duration FROM songs WHERE album_id = :album_id";
            $stmt = Application::$app->db->prepare($query);

            $stmt->bindParam(':album_id', $album_id);

            $stmt->execute();
            $result = $stmt->fetch();

            if ($result && isset($result['total_duration'])) {
                return (int)$result['total_duration'];
            } else {
                return 0;
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return null;
        }
    }
}
