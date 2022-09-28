<?php

namespace Tests\Unit;

use Carbon\Carbon;

use App\Repo\MysqlRepo\Notification;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Support\Facades\DB;

use PDO;

class MysqlTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @group unit
     */
    public function testUpdateKeyAndReceivedShouldWork(): void
    {
        //arrange
        $to = 'foo';
        $name = 'bar';
        $message = 'hello world';
        $type = 1;
        $sent = 0;
        $key = 'buzz';
        $dateTime = Carbon::now();
        $this->insertDummyData(
            $to,
            $name,
            $message,
            $type,
            $sent,
            $key,
            $dateTime
        );
        $repository = new Notification();

        //act
        $repository->UpdateToSuccessReceived($key);

        //assert
        $dbRecord = $this->findByKey($key);
        $this->assertSame(1, $dbRecord['received']);
    }

    public function findByKey(string $key): array
    {
        $pdo = $this->getPdo();
        $result = $pdo->query("SELECT * FROM notifications WHERE `key` = '$key'");

        return $result->fetch(PDO::FETCH_ASSOC);
    }

    private function insertDummyData(
        string $to,
        string $name,
        string $message,
        string $type,
        int $sent,
        string $key,
        Carbon $dateTime
    ): void {
        $pdo = $this->getPdo();
        $sql = 'INSERT INTO notifications' .
            '(`to`, `name`, `message`, `type`, `received`, `key`, `created_at`, `updated_at`)' .
            'VALUES (?,?,?,?,?,?,?,?)';
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            $to,
            $name,
            $message,
            $type,
            $sent,
            $key,
            $dateTime,
            $dateTime
        ]);
    }

    private function getPdo(): PDO
    {
        return DB::connection()->getPdo();
    }
}
