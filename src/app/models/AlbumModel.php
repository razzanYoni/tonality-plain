<?php

namespace models;

use bases\BaseModel;

class AlbumModel extends BaseModel
{
    private $_albumId;
    private $_albumName;
    private $_releaseDate;
    private $_genre;
    private $_artist;
    private $_coverUrl;

    public function __construct(array $data)
    {
        $this->constructFromArray($data);
        return $this;
    }

    public function constructFromArray(array $data): AlbumModel
    {
        $this->_albumId = $data['album_id'];
        $this->_albumName = $data['album_name'];
        $this->_releaseDate = $data['release_date'];
        $this->_genre = $data['genre'];
        $this->_artist = $data['artist'];
        $this->_coverUrl = $data['cover_url'];
        return $this;
    }

    public function toResponse(): array
    {
        return array(
            'album_id' => $this->_albumId,
            'album_name' => $this->_albumName,
            'release_date' => $this->_releaseDate,
            'genre' => $this->_genre,
            'artist' => $this->_artist,
            'cover_url' => $this->_coverUrl
        );
    }
}