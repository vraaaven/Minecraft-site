<?php

namespace App\Models;

use App\Core\Db;
use App\Lib\PostInfo;

class Post
{
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

    public static function getCategories(): array
    {
        return Db::getInstance()->row('SELECT * FROM categories');
    }

    public static function getCount($isAdmin = false): int
    {
        if (!$isAdmin) {
            $sql = 'SELECT COUNT(id) FROM posts';
        } else {
            $sql = 'SELECT COUNT(id) FROM posts WHERE id_xml = "none"';
        }
        return Db::getInstance()->column($sql);
    }

    public static function getItem($id): object
    {
        $arRes = Db::getInstance()->row('SELECT * FROM posts WHERE id =' . $id)[0];
        $object = PostInfo::getFromArray($arRes);
        return $object;
    }

    public static function deletePost($id): void
    {
        $params = [
            'id' => $id,
        ];
        Db::getInstance()->query(
            'DELETE FROM reactions_users WHERE reaction_id IN (SELECT id FROM reactions WHERE post_id = :id)',
            $params
        );
        Db::getInstance()->query('DELETE FROM reactions WHERE post_id = :id', $params);
        Db::getInstance()->query('DELETE FROM posts WHERE id = :id', $params);
    }

    public static function addPost(): void
    {
        $post = [
            'name' => htmlspecialchars($_POST['name']),
            'category_id' => (int)$_POST['category'],
            'announce' => htmlspecialchars($_POST['description']),
            'detail_text' => htmlspecialchars($_POST['description']),
            'date' => htmlspecialchars($_POST['date']),
            'id_xml' => 'none',
        ];
        Db::getInstance()->query(
            'INSERT INTO posts (name, announce, detail_text, date, id_xml,category_id) 
            VALUES (:name, :announce, :detail_text, :date, :id_xml, :category_id)',
            $post
        );
    }
    public static function updatePost($id): void
    {
        $params = [
            'id' => $id,
            'name' => htmlspecialchars($_POST['name']),
            'detail_text' => htmlspecialchars($_POST['description']),
            'category_id' => (int)$_POST['category'],
        ];
        Db::getInstance()->query(
            'UPDATE posts SET name = :name, detail_text = :detail_text, category_id = :category_id WHERE id = :id',
            $params
        );
    }
    public static function addCategory($xml): void
    {
        foreach ($xml->shop->categories->category as $category) {
            $cat = [
                "id_xml" => (int)$category->attributes()->id,
                'name' => (string)$category
            ];
            $param = [
                'id_xml' => $cat['id_xml'],
            ];
            $result = Db::getInstance()->row(
                'SELECT EXISTS(SELECT 1 FROM categories WHERE id_xml = :id_xml) as record_exists',
                $param
            );
            if ($result[0]['record_exists'] != 1) {
                Db::getInstance()->query('INSERT INTO categories (name,id_xml) VALUES (:name, :id_xml)', $cat);
            }
        }
    }

}
