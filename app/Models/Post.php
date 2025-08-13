<?php

namespace App\Models;

use App\Core\Db;
use App\Lib\PostInfo;

class Post
{
    /**
     * Получает все новости без фильтрации (базовый метод).
     * @param int $page Номер страницы.
     * @param int $limit Количество новостей на странице.
     * @return array
     */
    public static function getList($page, $limit): array
    {
        $params = [
            'start' => ($page - 1) * $limit,
            'limit' => $limit,
        ];
        $sql = 'SELECT * FROM posts ORDER BY date DESC LIMIT :start, :limit';
        $posts = Db::getInstance()->row($sql, $params);
        $aRes = [];
        foreach ($posts as $post) {
            $object = PostInfo::getFromArray($post);
            $aRes[] = $object;
        }
        return $aRes;
    }

    /**
     * Получает новости, доступные пользователю (фильтрованный метод).
     * @param int $page Номер страницы.
     * @param int $limit Количество новостей на странице.
     * @param bool $isPlayer Статус игрока, определяющий, какие новости показывать.
     * @return array
     */
    public static function getPostsForUser($page, $limit, $isPlayer): array
    {
        $params = [
            'start' => ($page - 1) * $limit,
            'limit' => $limit,
        ];

        $whereClause = !$isPlayer ? 'WHERE is_server_post = 0' : '';

        $sql = "SELECT * FROM posts {$whereClause} ORDER BY date DESC LIMIT :start, :limit";
        $posts = Db::getInstance()->row($sql, $params);
        $aRes = [];
        foreach ($posts as $post) {
            $object = PostInfo::getFromArray($post);
            $aRes[] = $object;
        }
        return $aRes;
    }

    /**
     * Получает общее количество всех новостей.
     * @return int
     */
    public static function getCount(): int
    {
        $sql = 'SELECT COUNT(id) FROM posts';
        return Db::getInstance()->column($sql);
    }

    /**
     * Получает количество новостей, доступных пользователю.
     * @param bool $isPlayer Статус игрока.
     * @return int
     */
    public static function getCountForUser($isPlayer): int
    {
        $whereClause = !$isPlayer ? 'WHERE is_server_post = 0' : '';
        $sql = "SELECT COUNT(id) FROM posts {$whereClause}";
        return Db::getInstance()->column($sql);
    }

    /**
     * Получает одну новость по её ID.
     * @param int $id ID новости.
     * @return object|null
     */
    public static function getItem(int $id): ?object
    {
        $arRes = Db::getInstance()->row('SELECT * FROM posts WHERE id = :id', ['id' => $id]);
        if (empty($arRes)) {
            return null;
        }
        return PostInfo::getFromArray($arRes[0]);
    }

    /**
     * Добавляет новую новость.
     * @param array $postData Данные новости.
     * @return void
     */
    public static function addPost(array $postData): void
    {
        $post = [
            'name' => htmlspecialchars($postData['name']),
            'code' => \App\Lib\Helper::slugify(htmlspecialchars($postData['name'])),
            'announce' => htmlspecialchars($postData['announce']),
            'detail_text' => htmlspecialchars($postData['detail_text']),
            'date' => date('Y-m-d H:i:s'), // <-- Добавляем текущую дату
            'is_server_post' => $postData['is_server_post'] ?? 0,
        ];
        Db::getInstance()->query(
            'INSERT INTO posts (name, announce, detail_text, date, is_server_post, code) 
            VALUES (:name, :announce, :detail_text, :date, :is_server_post, :code)',
            $post
        );
    }

    /**
     * Обновляет новость по её ID.
     * @param int $id ID новости.
     * @param array $postData Данные новости для обновления.
     * @return void
     */
    public static function updatePost(int $id, array $postData): void
    {
        $params = [
            'id' => $id,
            'name' => htmlspecialchars($postData['name']),
            'code' => \App\Lib\Helper::slugify(htmlspecialchars($postData['name'])),
            'announce' => htmlspecialchars($postData['announce']),
            'detail_text' => htmlspecialchars($postData['detail_text']),
            'is_server_post' => $postData['is_server_post'] ?? 0,
        ];
        Db::getInstance()->query(
            'UPDATE posts SET name = :name, announce = :announce, detail_text = :detail_text, code = :code ,is_server_post = :is_server_post WHERE id = :id',
            $params
        );
    }

    /**
     * Удаляет новость по её ID.
     * @param int $id ID новости.
     * @return void
     */
    public static function deletePost(int $id): void
    {
        $params = ['id' => $id];
        Db::getInstance()->query('DELETE FROM posts WHERE id = :id', $params);
    }
    public static function getItemByCode(string $code): ?object
    {
        $arRes = Db::getInstance()->row('SELECT * FROM posts WHERE code = :code', ['code' => $code]);
        if (empty($arRes)) {
            return null;
        }
        return PostInfo::getFromArray($arRes[0]);
    }
}