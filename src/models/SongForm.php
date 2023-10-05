<?php

namespace models;

require_once ROOT_DIR . "src/cores/Model.php";

use cores,
    repositories\SongRepository;

class SongForm extends cores\Model {
    public string $album_id = '';
    public string $title = '';
    public string $artist = '';
    public int $song_number = 0;
    public int $disc_number = 0;

    public int $duration = 0;
    public string $audio_url = '';

    public function rules() {
        return [
            'album_id' => [self::RULE_REQUIRED],
            'title' => [self::RULE_REQUIRED],
            'artist' => [self::RULE_REQUIRED],
            'song_number' => [self::RULE_REQUIRED],
            'disc_number' => [self::RULE_REQUIRED],
            'duration' => [self::RULE_REQUIRED],
            'audio_url' => [self::RULE_REQUIRED]
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
        ];
    }

    public function insertSong() : bool {
        return cores\Application::isNotAdmin();
    }
}