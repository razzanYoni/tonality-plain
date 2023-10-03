<?php

namespace repositories;

use bases\BaseRepository;

class PlaylistRepository extends BaseRepository {
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

    public function getPlaylists($user_id) {
        return $this->getOne(["user_id" => $user_id]);
    }

    public function getPlaylistByName($playlist_name) {
        return $this->getOne(["playlist_name" => $playlist_name]);
    }

    public function getSongsFromPlaylist($playlist_id) {
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
