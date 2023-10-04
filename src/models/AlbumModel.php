<?php

namespace models;

use bases\BaseModel;

class AlbumModel extends BaseModel
{
    public $_albumId;
    public $_albumName;
    public $_releaseDate;
    public $_genre;
    public $_artist;
    public $_coverUrl;

    public static function tableName(): string
    {
        return 'albums';
    }

    public static function primaryKey(): string
    {
        return 'album_id';
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