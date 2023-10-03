<?php

namespace bases;

abstract class BaseService {
  protected static BaseService $instance;
  protected BaseRepository $repository;

    public static function getInstance(): BaseService
    {
        if (!isset(self::$instance)) {
            self::$instance = new static();
        }
        return self::$instance;
    }
}