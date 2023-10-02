<?php

namespace models;

use bases\BaseModel;

class PlaylistModel extends BaseModel
{
    private $_playlistId;
    private $_userId;
    private $_playlistName;
    private $_description;
    private $_coverUrl;

    public function __construct(array $data)
    {
        $this->constructFromArray($data);
        return $this;
    }

    public function constructFromArray(array $data): PlaylistModel
    {
        $this->_playlistId = $data['playlist_id'];
        $this->_userId = $data['user_id'];
        $this->_playlistName = $data['playlist_name'];
        $this->_description = $data['description'];
        $this->_coverUrl = $data['cover_url'];
        return $this;
    }

    public function toResponse(): array
    {
        return array(
            'playlist_id' => $this->_playlistId,
            'user_id' => $this->_userId,
            'playlist_name' => $this->_playlistName,
            'description' => $this->_description,
            'cover_url' => $this->_coverUrl,
        );
    }
}