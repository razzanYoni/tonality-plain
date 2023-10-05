<?php

namespace models;

use bases\BaseModel;

class PlaylistModel extends BaseModel
{
    protected $playlist_id;
    protected $user_id;
    protected $playlist_name;
    protected $description;
    protected $cover_url;

    public function constructFromArray(array $data): PlaylistModel
    {
        $this->playlist_id = $data['playlist_id'];
        $this->user_id = $data['user_id'];
        $this->playlist_name = $data['playlist_name'];
        $this->description = $data['description'];
        $this->cover_url = $data['cover_url'];
        return $this;
    }

    public function toArray(): array
    {
        return array(
            'user_id' => $this->user_id,
            'playlist_name' => $this->playlist_name,
            'description' => $this->description,
            'cover_url' => $this->cover_url,
        );
    }
}