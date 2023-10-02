<?php

namespace models;

use bases\BaseModel;

class SongModel extends BaseModel
{
    private $_songId;
    private $_albumId;
    private $_title;
    private $_artist;
    private $_songNumber;
    private $_discNumber;
    private $_duration;
    private $_audioUrl;

    public function __construct(array $data)
    {
        $this->constructFromArray($data);
        return $this;
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