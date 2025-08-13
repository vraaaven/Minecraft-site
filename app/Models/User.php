<?php

namespace App\Models;

use App\Core\Db;

class User
{
    public static function create(
        string $name,
        string $email,
        string $password,
        string $token, // Токен перемещен сюда, так как он обязательный
        ?string $twitchName = null,
        int $isPlayer = 0,
        int $isAdmin = 0
    ): int
    {
        if (self::findByName($name) || self::findByEmail($email)) {
            return 0;
        }

        $params = [
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'twitch_name' => $twitchName,
            'is_player' => $isPlayer,
            'is_admin' => $isAdmin,
            'confirmation_token' => $token,
            'is_confirmed' => 0
        ];

        $sql = 'INSERT INTO users (name, email, password, twitch_name, is_player, is_admin, confirmation_token, is_confirmed) VALUES (:name, :email, :password, :twitch_name, :is_player, :is_admin, :confirmation_token, :is_confirmed)';
        Db::getInstance()->query($sql, $params);

        return (int)Db::getInstance()->lastInsertId();
    }
    public static function findByConfirmationToken(string $token): ?array
    {
        $params = ['token' => $token];
        $result = Db::getInstance()->row('SELECT * FROM users WHERE confirmation_token = :token', $params);
        return empty($result) ? null : $result[0];
    }

    public static function confirmUser(int $id): bool
    {
        $params = ['id' => $id];
        $sql = 'UPDATE users SET is_confirmed = 1, confirmation_token = NULL WHERE id = :id';
        $stmt = Db::getInstance()->query($sql, $params);
        return $stmt->rowCount() > 0;
    }

    public static function findById(int $id): ?array
    {
        $params = ['id' => $id];
        $result = Db::getInstance()->row('SELECT * FROM users WHERE id = :id', $params);
        return empty($result) ? null : $result[0];
    }

    public static function findByName(string $name): ?array
    {
        $params = ['name' => $name];
        $result = Db::getInstance()->row('SELECT * FROM users WHERE name = :name', $params);
        return empty($result) ? null : $result[0];
    }

    public static function findByEmail(string $email): ?array
    {
        $params = ['email' => $email];
        $result = Db::getInstance()->row('SELECT * FROM users WHERE email = :email', $params);
        return empty($result) ? null : $result[0];
    }

    public static function update(int $id, array $data): bool
    {
        if (empty($data)) {
            return false;
        }

        $setParts = [];
        $params = ['id' => $id];

        foreach ($data as $key => $value) {
            $setParts[] = "`{$key}` = :{$key}";
            $params[$key] = $value;
        }

        $sql = 'UPDATE users SET ' . implode(', ', $setParts) . ' WHERE id = :id';
        $stmt = Db::getInstance()->query($sql, $params);

        return $stmt->rowCount() > 0;
    }

    public static function delete(int $id): bool
    {
        $params = ['id' => $id];
        $stmt = Db::getInstance()->query('DELETE FROM users WHERE id = :id', $params);
        return $stmt->rowCount() > 0;
    }

    public static function isPlayer(): bool
    {
        if (!isset($_SESSION['user_id'])) {
            return false;
        }
        $sql = 'SELECT is_player FROM users WHERE id = :id';
        $params = ['id' => $_SESSION['user_id']];
        $result = Db::getInstance()->column($sql, $params);
        return (bool)$result;
    }
    public static function getList(int $page, int $limit): array
    {
        $params = [
            'start' => ($page - 1) * $limit,
            'limit' => $limit,
        ];
        $sql = 'SELECT * FROM users ORDER BY id DESC LIMIT :start, :limit';
        return Db::getInstance()->row($sql, $params);
    }

    /**
     * Получает общее количество пользователей.
     * @return int Общее количество пользователей.
     */
    public static function getCount(): int
    {
        $sql = 'SELECT COUNT(id) FROM users';
        return Db::getInstance()->column($sql);
    }
    public static function searchByName(string $name, int $page, int $limit): array
    {
        $params = [
            'name' => "%{$name}%",
            'start' => ($page - 1) * $limit,
            'limit' => $limit,
        ];
        $sql = 'SELECT * FROM users WHERE name LIKE :name ORDER BY id DESC LIMIT :start, :limit';
        return Db::getInstance()->row($sql, $params);
    }

    /**
     * Подсчитывает общее количество пользователей, найденных по имени.
     * @param string $name Имя для поиска.
     * @return int Общее количество пользователей.
     */
    public static function getCountByName(string $name): int
    {
        $params = ['name' => "%{$name}%"];
        $sql = 'SELECT COUNT(id) FROM users WHERE name LIKE :name';
        return Db::getInstance()->column($sql, $params);
    }
}