<?php

namespace models;

use bases\BaseModel;

class PremiumAlbumModel extends BaseModel
{
    protected $album_id;
    protected $album_name;
    protected $release_date;
    protected $genre;
    protected $artist;
    protected $cover_filename;
    public function constructFromArray($data)
    {
        $this->album_id = $data['albumId'];
        $this->album_name = $data['albumName'];
        $this->release_date = $data['releaseDate'];
        $this->genre = $data['genre'];
        $this->artist = $data['artist'];
        $this->cover_filename = $data['coverFilename'];
        return $this;
    }

    public function toArray(): array
    {
        return [
            'albumId' => $this->album_id,
            'albumName' => $this->album_name,
            'releaseDate' => $this->release_date,
            'genre' => $this->genre,
            'artist' => $this->artist,
            'coverFilename' => $this->cover_filename
        ];
    }
}