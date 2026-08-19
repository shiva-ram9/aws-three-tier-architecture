<?php
declare(strict_types=1);

header('Content-Type: text/html; charset=utf-8');

$dbHost = getenv('DB_HOST') ?: '';
$dbName = getenv('DB_NAME') ?: 'appdb';
$dbUser = getenv('DB_USER') ?: '';
$dbPassword = getenv('DB_PASSWORD') ?: '';
$databaseStatus = 'Not configured';

if ($dbHost !== '' && $dbUser !== '' && $dbPassword !== '') {
    try {
        $pdo = new PDO(
            "mysql:host={$dbHost};dbname={$dbName};charset=utf8mb4",
            $dbUser,
            $dbPassword,
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );
        $pdo->query('SELECT 1');
        $databaseStatus = 'Connected';
    } catch (Throwable $error) {
        $databaseStatus = 'Connection unavailable';
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AWS Three-Tier Application</title>
    <style>
        body { font-family: system-ui, sans-serif; margin: 0; background: #f4f7fb; color: #172033; }
        main { max-width: 720px; margin: 10vh auto; padding: 2rem; background: white; border-radius: 16px; box-shadow: 0 12px 40px #2233aa18; }
        .ok { color: #087f5b; font-weight: 700; }
        code { background: #eef2ff; padding: .2rem .4rem; border-radius: 4px; }
    </style>
</head>
<body>
<main>
    <h1>AWS Three-Tier Web Application</h1>
    <p class="ok">Application tier is healthy.</p>
    <p>Database status: <strong><?= htmlspecialchars($databaseStatus) ?></strong></p>
    <p>Health check: <code>/health.html</code></p>
</main>
</body>
</html>

