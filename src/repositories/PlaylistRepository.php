<?php

namespace repositories;

use bases\BaseRepository;
use PDOException;

class PlaylistRepository extends BaseRepository
{
    protected string $table = "playlists";

    public static function getInstance(): PlaylistRepository
    {
        if (!isset(self::$instance)) {
            self::$instance = new PlaylistRepository();
        }
        return self::$instance;
    }

    public function getPlaylists($user_id)
    {
        return $this->getOne(["user_id" => $user_id]);
    }

    public function getPlaylistByName($playlist_name)
    {
        return $this->getOne(["playlist_name" => $playlist_name]);
    }

    public function getSongsFromPlaylist($playlist_id): bool|array
    {
        try {
            $query = "SELECT * FROM songs WHERE playlist_id = :playlist_id";
            $stmt = $this->pdo->prepare($query);

            $stmt->bindParam(':playlist_id', $playlist_id);

            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return [];
        }
    }
}