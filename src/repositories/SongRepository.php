<?php

namespace repositories;

use bases\BaseRepository;

class SongRepository extends BaseRepository {
    protected static $instance;
    protected $table = "songs";

    private function __contruct() {
        parent::__construct();
    }

    public static function getInstance() {
        if (!isset(self::$instance)) {
            self::$instance = new SongRepository();
        }
        return self::$instance;
    }

    public function getSongById($song_id) {
        return $this->getOne(["song_id" => $song_id]);
    }

    public function getSongByTitle($title) {
        return $this->getAll(where: ["title" => $title]);
    }

    public function getSongByArtist($artist) {
        return $this->getAll(where: ["artist" => $artist]);
    }
}
