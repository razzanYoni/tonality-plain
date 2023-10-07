<?php

namespace repositories;

require_once ROOT_DIR . 'src/utils/FileProcessing.php';

use cores\Application,
    bases\BaseRepository,
    PDOException,
    utils\FileProcessing;

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
            'cover_filename'
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

    public function insert(array $data): bool
    {
        $data['cover_filename'] = FileProcessing::getInstance()->processFile();
        return parent::insert($data);
    }
}
