<?php

namespace App\Models;

use App\Core\Db;


class Page
{
    protected static string $table = 'pages';

    public static function getList(): array
    {
        $sql = 'SELECT * FROM ' . self::$table . ' ORDER BY url ASC';
        return Db::getInstance()->row($sql);
    }

    public static function getItem(int $id): array
    {
        $params = ['id' => $id];
        $sql = 'SELECT * FROM ' . self::$table . ' WHERE id = :id';
        return Db::getInstance()->row($sql, $params, static::class)[0];
    }

    public static function create(array $data): void
    {
        $params = [
            'url' => htmlspecialchars($data['url']),
            'title' => htmlspecialchars($data['title']),
            'description' => htmlspecialchars($data['description']),
            'keywords' => htmlspecialchars($data['keywords'])
        ];
        $sql = 'INSERT INTO ' . self::$table . ' (url, title, description, keywords) VALUES (:url, :title, :description, :keywords)';
        Db::getInstance()->query($sql, $params);
    }

    public static function update(int $id, array $data): void
    {
        $params = [
            'id' => $id,
            'url' => htmlspecialchars($data['url']),
            'title' => htmlspecialchars($data['title']),
            'description' => htmlspecialchars($data['description']),
            'keywords' => htmlspecialchars($data['keywords'])
        ];
        $sql = 'UPDATE ' . self::$table . ' SET url = :url, title = :title, description = :description, keywords = :keywords WHERE id = :id';
        Db::getInstance()->query($sql, $params);
    }

    public static function delete(int $id): void
    {
        $params = ['id' => $id];
        $sql = 'DELETE FROM ' . self::$table . ' WHERE id = :id';
        Db::getInstance()->query($sql, $params);
    }

    public static function getByUrl(string $url): ?array
    {
        $params = ['url' => $url];
        $sql = 'SELECT * FROM ' . self::$table . ' WHERE url = :url LIMIT 1';
        return Db::getInstance()->row($sql, $params, static::class)[0] ?? null;
    }
}