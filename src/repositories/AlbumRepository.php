<?php

namespace repositories;

require_once ROOT_DIR . 'src/utils/FileProcessing.php';

use bases\BaseRepository,
    utils\FileProcessing;

class AlbumRepository extends BaseRepository
{
    protected static BaseRepository $instance;

    public static function tableName(): string
    {
        return 'albums';
    }

    public static function attributes(): array
    {
        return [
            'album_name',
            'release_date',
            'genre',
            'artist',
            'cover_filename'
        ];
    }

    public static function primaryKey(): string
    {
        return 'album_id';
    }

    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new static();
        }
        return self::$instance;
    }

    public function getAllAlbum($order = null, $is_desc = false, $where = [], $where_like = '',$limit = ROWS_PER_PAGE, $offset = null): bool|array
    {
        if ($where_like === '') {
            $where_like = [];
        } else {
            $where_like = [
                "album_name" => $where_like,
                "artist" => $where_like,
            ];
        }

        return parent::findAll(
            order: $order,
            is_desc: $is_desc,
            where: $where,
            where_like:  $where_like,
            limit: $limit,
            offset: $offset
        );
    }

    public function getCountAlbums($where, $where_like = ''): int
    {
        if ($where_like === '') {
            $where_like = [];
        } else {
            $where_like = [
                "album_name" => $where_like,
                "artist" => $where_like,
            ];
        }

        return parent::aggregate(
            method: 'COUNT',
            alias: 'count_albums',
            where: $where,
            where_like: $where_like
        )['count_albums'];
    }

    public function getAlbumById($album_id)
    {
        return $this->findOne(["album_id" => $album_id]);
    }

    public function getAlbumGenres(): bool|array
    {
        return parent::findAll(options: 'DISTINCT genre');
    }

    public function insert(array $data): bool
    {
        $data['cover_filename'] = FileProcessing::getInstance()->processFile();
        return parent::insert($data);
    }

    public function update($id, array $data): bool
    {
        $data['cover_filename'] = FileProcessing::getInstance()->processFile();
        return parent::update($id, $data);
    }
}
