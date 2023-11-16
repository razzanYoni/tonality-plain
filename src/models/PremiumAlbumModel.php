<?php

namespace models;

use bases\BaseModel;

class PremiumAlbumModel
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
}