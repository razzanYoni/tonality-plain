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
    protected $audio_filename;

    public function rules(): array
    {
        return [
            'title' => [self::RULE_REQUIRED],
            'artist' => [self::RULE_REQUIRED],
            'song_number' => [self::RULE_REQUIRED, [self::RULE_MIN_VALUE, 'minValue' => 1]],
            'disc_number' => [[self::RULE_MIN_VALUE, 'minValue' => 1]],
            'duration' => [self::RULE_REQUIRED],
            'audio_filename' => [self::RULE_REQUIRED, self::RULE_MAX_FILE_SIZE],
        ];
    }

    public function labels(): array
    {
        return [
            'title' => 'Title',
            'artist' => 'Artist',
            'song_number' => 'Song Number',
            'disc_number' => 'Disc Number',
            'duration' => 'Duration (in seconds)',
            'audio_filename' => 'Audio File',
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
        $this->audio_filename = $data['audio_filename'];
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
            'audio_filename' => $this->audio_filename,
        );
    }
}