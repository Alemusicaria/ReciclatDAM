<?php

declare(strict_types=1);

/**
 * Imports database-reciclatdam.sql into the database configured in .env.
 *
 * Usage:
 *   php tools/import_sql_dump.php
 */

$root = dirname(__DIR__);
$envPath = $root . DIRECTORY_SEPARATOR . '.env';
$sqlPath = $root . DIRECTORY_SEPARATOR . 'database-reciclatdam.sql';

if (!file_exists($envPath)) {
    fwrite(STDERR, "[ERROR] .env file not found. Copy .env.example to .env first.\n");
    exit(1);
}

if (!file_exists($sqlPath)) {
    fwrite(STDERR, "[ERROR] SQL dump not found at database-reciclatdam.sql.\n");
    exit(1);
}

$env = parseEnvFile($envPath);

$host = envValue($env, 'DB_HOST', '127.0.0.1');
$port = envValue($env, 'DB_PORT', '3306');
$database = envValue($env, 'DB_DATABASE', '');
$username = envValue($env, 'DB_USERNAME', 'root');
$password = envValue($env, 'DB_PASSWORD', '');

if ($database === '') {
    fwrite(STDERR, "[ERROR] DB_DATABASE is empty in .env.\n");
    exit(1);
}

$dsn = sprintf('mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4', $host, $port, $database);

try {
    $pdo = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);
} catch (Throwable $e) {
    fwrite(STDERR, "[ERROR] Database connection failed: {$e->getMessage()}\n");
    exit(1);
}

$sql = file_get_contents($sqlPath);
if ($sql === false) {
    fwrite(STDERR, "[ERROR] Failed to read SQL dump.\n");
    exit(1);
}

$statements = splitSqlStatements(cleanSql($sql));

if ($statements === []) {
    fwrite(STDERR, "[ERROR] No SQL statements found in dump.\n");
    exit(1);
}

$executed = 0;

try {
    foreach ($statements as $statement) {
        $trimmed = trim($statement);
        if ($trimmed === '') {
            continue;
        }
        $pdo->exec($trimmed);
        $executed++;
    }
} catch (Throwable $e) {
    fwrite(STDERR, "[ERROR] Import failed after {$executed} statements: {$e->getMessage()}\n");
    exit(1);
}

fwrite(STDOUT, "[OK] SQL import completed. Executed {$executed} statements into '{$database}'.\n");
exit(0);

function parseEnvFile(string $path): array
{
    $values = [];
    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    if ($lines === false) {
        return $values;
    }

    foreach ($lines as $line) {
        $line = trim($line);
        if ($line === '' || str_starts_with($line, '#')) {
            continue;
        }

        $parts = explode('=', $line, 2);
        if (count($parts) !== 2) {
            continue;
        }

        $key = trim($parts[0]);
        $value = trim($parts[1]);

        if ((str_starts_with($value, '"') && str_ends_with($value, '"')) ||
            (str_starts_with($value, "'") && str_ends_with($value, "'"))) {
            $value = substr($value, 1, -1);
        }

        $values[$key] = $value;
    }

    return $values;
}

function envValue(array $env, string $key, string $default): string
{
    if (!array_key_exists($key, $env)) {
        return $default;
    }

    return (string) $env[$key];
}

function cleanSql(string $sql): string
{
    $sql = preg_replace('/^\xEF\xBB\xBF/', '', $sql) ?? $sql;

    // Remove MySQL versioned comments and block comments.
    $sql = preg_replace('/\/\*![\s\S]*?\*\//', '', $sql) ?? $sql;
    $sql = preg_replace('/\/\*[\s\S]*?\*\//', '', $sql) ?? $sql;

    // Remove single-line SQL comments starting with --
    $lines = preg_split('/\R/', $sql) ?: [];
    $filtered = [];
    foreach ($lines as $line) {
        $line = preg_replace('/^\xEF\xBB\xBF/', '', $line) ?? $line;

        if (preg_match('/^\s*(--|#)/', $line) === 1) {
            continue;
        }
        $filtered[] = $line;
    }

    return implode("\n", $filtered);
}

function splitSqlStatements(string $sql): array
{
    $statements = [];
    $buffer = '';
    $inSingleQuote = false;
    $inDoubleQuote = false;
    $length = strlen($sql);

    for ($i = 0; $i < $length; $i++) {
        $char = $sql[$i];
        $prev = $i > 0 ? $sql[$i - 1] : '';

        if ($char === "'" && $prev !== '\\' && !$inDoubleQuote) {
            $inSingleQuote = !$inSingleQuote;
        } elseif ($char === '"' && $prev !== '\\' && !$inSingleQuote) {
            $inDoubleQuote = !$inDoubleQuote;
        }

        if ($char === ';' && !$inSingleQuote && !$inDoubleQuote) {
            $statements[] = $buffer;
            $buffer = '';
            continue;
        }

        $buffer .= $char;
    }

    if (trim($buffer) !== '') {
        $statements[] = $buffer;
    }

    return $statements;
}
