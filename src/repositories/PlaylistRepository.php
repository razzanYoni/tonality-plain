<?php

namespace repositories;

use bases\BaseRepository;
use cores\Application;
use utils\FileProcessing;

class PlaylistRepository extends BaseRepository
{
    protected static BaseRepository $instance;

    public static function tableName(): string
    {
        return 'playlists';
    }

    public static function attributes(): array
    {
        return [
            'user_id',
            'playlist_name',
            'description',
            'cover_filename'
        ];
    }

    public static function primaryKey(): string
    {
        return 'playlist_id';
    }

    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new static();
        }
        return self::$instance;
    }

    public function getPlaylistsByUserId($order = null, $is_desc = false, $where = [], $where_like = '', $limit = ROWS_PER_PAGE, $offset = null): bool|array
    {
        if ($where_like === '') {
            $where_like = [];
        } else {
            $where_like = [
                "playlist_name" => $where_like,
            ];
        }

        return parent::findAll(
            order: $order,
            is_desc: $is_desc,
            where: $where,
            where_like: $where_like,
            limit: $limit,
            offset: $offset
        );
    }

    public function getCountPlaylistByUserId($where = [], $where_like = ''): int
    {
        if ($where_like === '') {
            $where_like = [];
        } else {
            $where_like = [
                "playlist_name" => $where_like,
            ];
        }

        return parent::aggregate(
            method: 'COUNT',
            alias: 'count_playlists',
            where: $where,
            where_like: $where_like
        )['count_playlists'];
    }

    public function getPlaylistById($playlist_id)
    {
        return $this->findOne(where: ["playlist_id" => $playlist_id]);
    }

    public function IsPlaylistIsOwned($playlist_id)
    {
        return $this->findOne(
            where: [
                "playlist_id" => $playlist_id,
                "user_id" => Application::$app->loggedUser->getUserId()
            ]);
    }

    public function insert(array $data): bool
    {
        $data['user_id'] = Application::getInstance()->loggedUser->getUserId();
        $data['cover_filename'] = FileProcessing::getInstance()->processFile();
        return parent::insert($data);
    }
}
