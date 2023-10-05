<?php

namespace models;

require_once ROOT_DIR . "src/bases/BaseModel.php";

use bases\BaseModel;

class SongModel extends BaseModel
{
    public $song_id;
    public $album_id;
    public $title;
    public $artist;
    public $song_number;
    public $disc_number;
    public $duration;
    public $audio_url;

    public static function tableName(): string
    {
        return 'songs';
    }

    public static function primaryKey(): string
    {
        return 'song_id';
    }

    public function attributes(): array
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

    public function rules()
    {
        return [
            'album_id' => [self::RULE_REQUIRED],
            'title' => [self::RULE_REQUIRED],
            'artist' => [self::RULE_REQUIRED],
            'song_number' => [self::RULE_REQUIRED],
//            'disc_number' => [self::RULE_REQUIRED],
            'duration' => [self::RULE_REQUIRED],
            'audio_url' => [self::RULE_REQUIRED],
        ];
    }

    public function labels()
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

    public function insert(): bool
    {
        // TODO : using filemanager to upload audio file
        return parent::insert();
    }

    public function toResponse(): array
    {
        return array(
            'song_id' => $this->song_id,
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