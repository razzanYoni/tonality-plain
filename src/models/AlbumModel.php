<?php

namespace models;

use bases\BaseModel;

class AlbumModel extends BaseModel
{
    protected $album_id;
    protected $album_name;
    protected $release_date;
    protected $genre;
    protected $artist;
    protected $cover_filename;

    public function constructFromArray(array $data): AlbumModel
    {
        $this->album_id = $data['album_id'];
        $this->album_name = $data['album_name'];
        $this->release_date = $data['release_date'];
        $this->genre = $data['genre'];
        $this->artist = $data['artist'];
        $this->cover_filename = $data['cover_filename'];
        return $this;
    }

    public function toArray(): array
    {
        return array(
            'album_name' => $this->album_name,
            'release_date' => $this->release_date,
            'genre' => $this->genre,
            'artist' => $this->artist,
            'cover_filename' => $this->cover_filename
        );
    }

    public function rules(): array
    {
        return [
            'album_name' => [self::RULE_REQUIRED],
            'release_date' => [self::RULE_REQUIRED],
            'genre' => [self::RULE_REQUIRED],
            'artist' => [self::RULE_REQUIRED],
            'cover_filename' => [self::RULE_MAX_FILE_SIZE]
        ];
    }

    public function labels(): array
    {
        return [
            'album_name' => 'Album Name',
            'release_date' => 'Release Date',
            'genre' => 'Genre',
            'artist' => 'Artist',
            'cover_filename' => 'Cover Photo'
        ];
    }
}
