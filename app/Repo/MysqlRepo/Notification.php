<?php

namespace App\Repo\MysqlRepo;

use App\Repo\NotificationInterface;
use Illuminate\Support\Facades\DB;
use PDO;

class Notification implements NotificationInterface
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = DB::connection()->getPdo();
    }

    public function UpdateToSuccessReceived(string $key): void
    {
        $sql = 'UPDATE notifications SET `received` = ? WHERE `key` = ?';
        // prepare
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([1, $key]);
    }
}
