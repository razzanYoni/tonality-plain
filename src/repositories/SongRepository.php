<?php

namespace repositories;

use bases\BaseRepository;

class SongRepository extends BaseRepository
{
    protected static BaseRepository $instance;
    public static function tableName(): string
    {
        return 'songs';
    }

    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new static();
        }
        return self::$instance;
    }

    public function getSongById($song_id)
    {
        return $this->findOne(["song_id" => $song_id]);
    }

    public function getSongByTitle($title): bool|array
    {
        return $this->findAll(where: ["title" => $title]);
    }

    public function getSongByArtist($artist): bool|array
    {
        return $this->findAll(where: ["artist" => $artist]);
    }
}