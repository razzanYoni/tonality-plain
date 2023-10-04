<?php

namespace models;

use bases\BaseModel;

class SongModel extends BaseModel
{
    public $_songId;
    public $_albumId;
    public $_title;
    public $_artist;
    public $_songNumber;
    public $_discNumber;
    public $_duration;
    public $_audioUrl;

    public static function tableName(): string
    {
        return 'songs';
    }

    public static function primaryKey(): string
    {
        return 'song_id';
    }

    public function constructFromArray(array $data): SongModel
    {
        $this->_songId = $data['song_id'];
        $this->_albumId = $data['album_id'];
        $this->_title = $data['title'];
        $this->_artist = $data['artist'];
        $this->_songNumber = $data['song_number'];
        $this->_discNumber = $data['disc_number'];
        $this->_duration = $data['duration'];
        $this->_audioUrl = $data['audio_url'];
        return $this;
    }

    public function getSongById($song_id)
    {
        return $this->findOne(where : ["song_id" => $song_id]);
    }

    public function getSongByTitle($title): bool|array
    {
        return $this->findAll(where: ["title" => $title]);
    }

    public function getSongByArtist($artist): bool|array
    {
        return $this->findAll(where: ["artist" => $artist]);
    }

    public function toResponse(): array
    {
        return array(
            'song_id' => $this->_songId,
            'album_id' => $this->_albumId,
            'title' => $this->_title,
            'artist' => $this->_artist,
            'song_number' => $this->_songNumber,
            'disc_number' => $this->_discNumber,
            'duration' => $this->_duration,
            'audio_url' => $this->_audioUrl,
        );
    }
}