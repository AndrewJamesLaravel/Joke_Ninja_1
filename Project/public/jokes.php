<?php


$dbInfo = 'mysql:host=localhost;dbname=joker;charset=utf8';
$dbUser = 'JokerDB_user';
$dbPassword = 'JokerDB_pass';
try {
    $pdo = new PDO($dbInfo, $dbUser, $dbPassword);
    $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

    $sql = 'SELECT `joketext`, `id` FROM `joke`';
    $jokes = $pdo->query($sql);

    $title = 'Joke list';

    ob_start();

    include __DIR__ . '/../templates/jokes.html.php';

    $output = ob_get_clean();

} catch (PDOException $e) {
    $title = 'An error has occurred';
    $output = 'Database error: ' . $e->getMessage() .
        ' in ' . $e->getFile() . ':' . $e->getLine();
}

include __DIR__ . '/../templates/layout.html.php';