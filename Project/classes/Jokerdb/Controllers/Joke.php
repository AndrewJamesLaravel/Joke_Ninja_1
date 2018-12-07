<?php

namespace Jokerdb\Controllers;
use \Ninja\DatabaseTable;

class Joke {
    private $authorsTable;
    private $jokesTable;

    public function __construct(DatabaseTable $jokesTable, DatabaseTable $authorsTable) {
        $this->jokesTable = $jokesTable;
        $this->authorsTable = $authorsTable;
    }
    public function list()
    {
    $result = $this->jokesTable->findAll();

    $jokes = [];
    foreach ($result as $joke) {
        $author = $this->authorsTable->findById($joke['authorId']);
        $jokes[] = [
            'id' => $joke['id'],
            'joketext' => $joke['joketext'],
            'jokedate' => $joke['jokedate'],
            'name' => $author['name'],
            'email' => $author['email']
        ];
    }

    $title = 'Joke list';

    $totalJokes = $this->jokesTable->total();

    return ['template' => 'jokes.html.php', 'title' => $title,
        'variables' => [
            'totalJokes' => $totalJokes,
            'jokes' => $jokes
        ]];
    }

    public function home() {
        $title = 'Internet Joke Database';
        return ['template' => 'home.html.php', 'title' => $title];
    }

    public function delete() {
        $this->jokesTable->delete($_POST['id']);

        header('location: /joke/list');
    }

    public function edit() {
        if (isset($_POST['joke'])) {

            $joke = $_POST['joke'];
            $joke['authorId'] = 1;
            $joke['jokedate'] = new \DateTime();
            $this->jokesTable->save($joke);

            header('location: /joke/list');

        } else {
            if (isset($_GET['id'])) {
                $joke = $this->jokesTable->findById($_GET['id']);
            }

            $title = 'Edit joke';

            return ['template' => 'editJoke.html.php', 'title' => $title,
                'variables' => [
                    'joke' => $joke ?? null
                ]];
        }
    }
}