<?php

namespace repositories;

use bases\BaseRepository;

class AppearsOnRepository extends BaseRepository
{
    protected static BaseRepository $instance;

    public static function tableName(): string
    {
        return 'appears_on';
    }

    public static function attributes(): array
    {
        return [
            'song_id',
            'playlist_id'
        ];
    }

    public static function primaryKey(): array
    {
        return ['song_id', 'playlist_id'];
    }

    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new static();
        }
        return self::$instance;
    }

    public function deleteSongFromPlaylist($song_id, $playlist_id)
    {
        return $this->delete(id: ["song_id" => $song_id, "playlist_id" => $playlist_id]);
    }

    public function insertSongToPlaylist($song_id, $playlist_id): bool
    {
        return $this->insert(["song_id" => $song_id, "playlist_id" => $playlist_id]);
    }
}
