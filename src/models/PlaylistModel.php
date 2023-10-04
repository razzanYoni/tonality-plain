<?php

namespace models;

use bases\BaseModel;

class PlaylistModel extends BaseModel
{
    public $_playlistId;
    public $_userId;
    public $_playlistName;
    public $_description;
    public $_coverUrl;


    public static function primaryKey(): string
    {
        return 'playlist_id';
    }

    public static function tableName(): string
    {
        return 'playlists';
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

    public function getPlaylistsByUserId()
    {
        return $this->findAll(where : ["user_id" => $this->_userId]);
    }

    public function getSongsFromPlaylist()
    {
        return $this->findAll(where : ["playlist_id" => $this->_playlistId]);
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