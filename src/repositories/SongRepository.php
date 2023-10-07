<?php

namespace repositories;

use bases\BaseRepository;
use cores\Application;
use PDOException;

class SongRepository extends BaseRepository
{
    protected static BaseRepository $instance;

    public static function tableName(): string
    {
        return 'songs';
    }

    public static function attributes(): array
    {
        return [
            'album_id',
            'title',
            'artist',
            'song_number',
            'disc_number',
            'duration',
            'audio_url',
        ];
    }

    public static function primaryKey(): string
    {
        return 'song_id';
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

    public function getSongsFromAlbum($album_id): bool|array
    {
        return $this->findAll(where: ["album_id" => $album_id]);
    }

    public function getSongsFromPlaylist($playlist_id): bool|array
    {
        return $this->findAll(where: ["playlist_id" => $playlist_id]);
    }

    public function getCountSongsFromAlbum($album_id): int
    {
        return $this->aggregate(
            method: 'COUNT',
            alias: 'total_songs',
            where : ["album_id" => $album_id],
        )['total_songs'];
    }

    public function getSongByTitle($title): bool|array
    {
        return $this->findAll(where: ["title" => $title]);
    }

    public function getSongByArtist($artist): bool|array
    {
        return $this->findAll(where: ["artist" => $artist]);
    }

    public function getAlbumDuration($album_id): bool|int
    {
        $result = parent::aggregate(
            method: 'SUM',
            alias: 'total_duration',
            where: ["album_id" => $album_id],
            column: 'duration'
        );

        if ($result && isset($result['total_duration'])) {
            return (int)$result['total_duration'];
        } else {
            return 0;
        }
    }
}