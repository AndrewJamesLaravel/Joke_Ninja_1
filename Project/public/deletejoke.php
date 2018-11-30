<?php

    $dbInfo = 'mysql:host=localhost;dbname=joker;charset=utf8';
    $dbUser = 'JokerDB_user';
    $dbPassword = 'JokerDB_pass';
    try {
        $pdo = new PDO($dbInfo, $dbUser, $dbPassword);
        $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

        $sql = 'DELETE FROM `joke` WHERE `id` = :id';

        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':id', $_POST['id']);
        $stmt->execute();

        header('location: jokes.php');

    } catch (PDOException $e) {
        $title = 'An error has occurred';
        $output = 'Database error: ' . $e->getMessage() .
            ' in ' . $e->getFile() . ':' . $e->getLine();
}

include __DIR__ . '/../templates/layout.html.php';