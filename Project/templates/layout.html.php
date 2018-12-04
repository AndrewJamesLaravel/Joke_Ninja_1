<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="jokes.css">
    <link rel="stylesheet" href="form.css">
    <title><?=$title?></title>
</head>
<body>

<header>
    <h1>Internet Joke Database</h1>
</header>

<nav>
    <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="jokes.php">Jokes List</a></li>
        <li><a href="editJoke.php">Add a new Joke</a></li>
    </ul>
</nav>

<main>
    <?=$output ?>
</main>

<footer>
    &copy; JOKER_DB 2018
</footer>

</body>
</html>