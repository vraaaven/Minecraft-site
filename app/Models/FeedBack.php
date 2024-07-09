<?php

namespace App\Models;

use App\Core\Db;

class FeedBack
{
    public static function addRecord($record): bool
    {
        $result = Db::getInstance()->query(
            'INSERT INTO feedback_entries (name, address, phone, email, session_id) 
            VALUES (:name, :address, :phone, :email, :session_id)',
            $record
        );
        return boolval($result);
    }
    public static function getRecord($sessionId): array
    {
        $params = ['session_id' => $sessionId];
        return Db::getInstance()->row('SELECT * FROM feedback_entries WHERE session_id = :session_id ORDER BY id DESC LIMIT 1', $params)[0];
    }
}