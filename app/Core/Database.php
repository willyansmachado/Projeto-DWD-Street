<?php
declare(strict_types=1);
namespace App\Core;
use PDO;
use PDOException;
final class Database {
    private static ?PDO $connection = null;
    public static function connect(array $config): void { if (self::$connection) return; $dsn = sprintf('mysql:host=%s;port=%s;dbname=%s;charset=%s', $config['host'], $config['port'], $config['database'], $config['charset']); try { self::$connection = new PDO($dsn, $config['username'], $config['password'], [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, PDO::ATTR_EMULATE_PREPARES => false]); } catch (PDOException $exception) { http_response_code(500); exit('Não foi possível conectar ao banco. Verifique config/database.php.'); } }
    public static function connection(): PDO { if (!self::$connection) throw new PDOException('Conexão não inicializada.'); return self::$connection; }
}
