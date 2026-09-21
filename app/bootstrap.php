<?php
declare(strict_types=1);
use App\Core\Database;
define('BASE_PATH', dirname(__DIR__));
spl_autoload_register(static function (string $class): void { $prefix = 'App\\'; if (!str_starts_with($class, $prefix)) return; $file = BASE_PATH . '/app/' . str_replace('\\', '/', substr($class, strlen($prefix))) . '.php'; if (is_file($file)) require $file; });
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
Database::connect(require BASE_PATH . '/config/database.php');
