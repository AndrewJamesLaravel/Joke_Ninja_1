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
        <li><a href="index.php?action=list">Jokes List</a></li>
        <li><a href="index.php?action=edit">Add a new Joke</a></li>
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