<?php

namespace models;

require_once ROOT_DIR . "src/bases/BaseModel.php";

use bases\BaseModel;

class SongModel extends BaseModel
{
    protected $song_id;
    protected $album_id;
    protected $title;
    protected $artist;
    protected $song_number;
    protected $disc_number;
    protected $duration;
    protected $audio_url;

    public function rules(): array
    {
        return [
            'album_id' => [self::RULE_REQUIRED],
            'title' => [self::RULE_REQUIRED],
            'artist' => [self::RULE_REQUIRED],
            'song_number' => [self::RULE_REQUIRED],
            'duration' => [self::RULE_REQUIRED],
            'audio_url' => [self::RULE_REQUIRED],
        ];
    }

    public function labels(): array
    {
        return [
            'album_id' => 'Album ID',
            'title' => 'Title',
            'artist' => 'Artist',
            'song_number' => 'Song Number',
            'disc_number' => 'Disc Number',
            'duration' => 'Duration',
            'audio_url' => 'Audio URL',
        ];
    }

    public function constructFromArray(array $data): SongModel
    {
        $this->song_id = $data['song_id'];
        $this->album_id = $data['album_id'];
        $this->title = $data['title'];
        $this->artist = $data['artist'];
        $this->song_number = $data['song_number'];
        $this->disc_number = $data['disc_number'];
        $this->duration = $data['duration'];
        $this->audio_url = $data['audio_url'];
        return $this;
    }

    public function toArray(): array
    {
        return array(
            'album_id' => $this->album_id,
            'title' => $this->title,
            'artist' => $this->artist,
            'song_number' => $this->song_number,
            'disc_number' => $this->disc_number,
            'duration' => $this->duration,
            'audio_url' => $this->audio_url,
        );
    }
}