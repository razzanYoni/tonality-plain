<?php

namespace repositories;

use bases\BaseRepository;

class SongRepository extends BaseRepository
{
    protected string $table = "songs";

    public static function getInstance(): SongRepository
    {
        if (!isset(self::$instance)) {
            self::$instance = new SongRepository();
        }
        return self::$instance;
    }

    public function getSongById($song_id)
    {
        return $this->getOne(["song_id" => $song_id]);
    }

    public function getSongByTitle($title): bool|array
    {
        return $this->getAll(where: ["title" => $title]);
    }

    public function getSongByArtist($artist): bool|array
    {
        return $this->getAll(where: ["artist" => $artist]);
    }
}