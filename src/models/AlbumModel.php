<?php

namespace models;

use bases\BaseModel;

class AlbumModel extends BaseModel
{
    public $album_id;
    public $album_name;
    public $release_date;
    public $genre;
    public $artist;
    public $cover_url;

    public static function tableName(): string
    {
        return 'albums';
    }

    public static function primaryKey(): string
    {
        return 'album_id';
    }

    public function attributes(): array
    {
        return [
            'album_id',
            'album_name',
            'release_date',
            'genre',
            'artist',
            'cover_url'
        ];
    }

    public function constructFromArray(array $data): AlbumModel
    {
        $this->album_id = $data['album_id'];
        $this->album_name = $data['album_name'];
        $this->release_date = $data['release_date'];
        $this->genre = $data['genre'];
        $this->artist = $data['artist'];
        $this->cover_url = $data['cover_url'];
        return $this;
    }

    public function toResponse(): array
    {
        return array(
            'album_id' => $this->album_id,
            'album_name' => $this->album_name,
            'release_date' => $this->release_date,
            'genre' => $this->genre,
            'artist' => $this->artist,
            'cover_url' => $this->cover_url
        );
    }
}
