<?php

namespace App\Models;

use App\Core\Db;

class Season
{
    public static function getList(): array
    {
        return Db::getInstance()->row('SELECT * FROM seasons ORDER BY number ASC');
    }

    public static function create(array $data): int
    {
        $sql = 'INSERT INTO seasons (number, title, description) VALUES (:number, :title, :description)';
        Db::getInstance()->query($sql, [
            'number' => $data['number'],
            'title' => $data['title'],
            'description' => $data['description'],
        ]);
        return Db::getInstance()->lastInsertId();
    }

    public static function update(int $id, array $data): void
    {
        $sql = 'UPDATE seasons SET number = :number, title = :title, description = :description WHERE id = :id';
        Db::getInstance()->query($sql, [
            'id' => $id,
            'number' => $data['number'],
            'title' => $data['title'],
            'description' => $data['description'],
        ]);
    }

    public static function delete(int $id): void
    {
        Db::getInstance()->query('DELETE FROM seasons WHERE id = :id', ['id' => $id]);
    }

    // Управление игроками сезона
    public static function syncPlayers(int $seasonId, array $playerIds): void
    {
        // Очищаем старые связи
        Db::getInstance()->query('DELETE FROM season_players WHERE season_id = :id', ['id' => $seasonId]);

        // Добавляем новые
        foreach ($playerIds as $userId) {
            Db::getInstance()->query('INSERT INTO season_players (season_id, user_id) VALUES (:s_id, :u_id)', [
                's_id' => $seasonId,
                'u_id' => (int)$userId
            ]);
        }
    }

    public static function getPlayerIds(int $seasonId): array
    {
        $rows = Db::getInstance()->row('SELECT user_id FROM season_players WHERE season_id = :id', ['id' => $seasonId]);
        return array_column($rows, 'user_id');
    }
    public static function findById(int $id): ?array
    {
        $result = Db::getInstance()->row('SELECT * FROM seasons WHERE id = :id', ['id' => $id]);
        return $result[0] ?? null;
    }
    /**
     * Получить всех игроков, участвовавших в конкретном сезоне
     */
    public static function getPlayers(int $seasonId): array
    {
        $sql = 'SELECT u.*, sp.role 
                FROM users u 
                JOIN season_players sp ON u.id = sp.user_id 
                WHERE sp.season_id = :season_id 
                ORDER BY u.id ASC';

        return Db::getInstance()->row($sql, ['season_id' => $seasonId]);
    }
    public static function getAdjacent(int $currentNumber): array
    {
        $db = Db::getInstance();

        // Следующий сезон (тот, у которого номер больше текущего)
        $next = $db->row('SELECT id, title, number FROM seasons WHERE number > :num ORDER BY number ASC LIMIT 1', ['num' => $currentNumber]);

        // Предыдущий сезон (тот, у которого номер меньше текущего)
        $prev = $db->row('SELECT id, title, number FROM seasons WHERE number < :num ORDER BY number DESC LIMIT 1', ['num' => $currentNumber]);

        return [
            'next' => $next[0] ?? null,
            'prev' => $prev[0] ?? null
        ];
    }
}