<?php

if (isset($_POST['joketext'])) {
        $dbInfo = 'mysql:host=localhost;dbname=joker;charset=utf8';
        $dbUser = 'JokerDB_user';
        $dbPassword = 'JokerDB_pass';
        try {
            $pdo = new PDO($dbInfo, $dbUser, $dbPassword);
            $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

            $sql = 'INSERT INTO `joke` SET 
                `joketext` = :joketext,
                `jokedate` = CURDATE()';

            $stmt = $pdo->prepare($sql);
            $stmt->bindValue('joketext', $_POST['joketext']);
            $stmt->execute();

            header('location: jokes.php');

    } catch (PDOException $e) {
        $title = 'An error has occurred';
            $output = 'Database error: ' . $e->getMessage() .
                ' in ' . $e->getFile() . ':' . $e->getLine();
    }
} else {
    $title = 'Add a new joke';

    ob_start();

    include __DIR__ . '/../templates/addjoke.html.php';

    $output = ob_get_clean();
}

include __DIR__ . '/../templates/layout.html.php';