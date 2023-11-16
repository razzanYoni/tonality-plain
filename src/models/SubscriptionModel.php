<?php

namespace models;

use bases\BaseModel;

class SubscriptionModel extends BaseModel
{

    protected $user_id;
    protected $premium_album_id;
    protected $status;

    public function constructFromArray(array $data)
    {
        $this->user_id = $data['user_id'];
        $this->premium_album_id = $data['premium_album_id'];
        $this->status = $data['status'];
    }

    public function toArray(): array
    {
        return [
            'userId' => $this->user_id,
            'premiumAlbumId' => $this->premium_album_id,
            'status' => $this->status
        ];
    }
}