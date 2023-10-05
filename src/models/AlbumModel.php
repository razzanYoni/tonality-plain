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
    protected $cover_url;

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

    public function toArray(): array
    {
        return array(
            'album_name' => $this->album_name,
            'release_date' => $this->release_date,
            'genre' => $this->genre,
            'artist' => $this->artist,
            'cover_url' => $this->cover_url
        );
    }
}
