<?php

namespace Jokerdb\Controllers;
use \Ninja\DatabaseTable;
use \Ninja\Authentication;

class Joke {
    private $authorsTable;
    private $jokesTable;
    private $categoriesTable;
    private $authentication;

    public function __construct(DatabaseTable $jokesTable,
                                DatabaseTable $authorsTable,
                                DatabaseTable $categoriesTable,
                                Authentication $authentication) {
        $this->jokesTable = $jokesTable;
        $this->authorsTable = $authorsTable;
        $this->categoriesTable = $categoriesTable;
        $this->authentication = $authentication;
    }
    public function list()
    {
        $page = $_GET['page'] ?? 1;
        $offSet = ($page - 1) * 10;

        if (isset($_GET['category'])) {
            $category = $this->categoriesTable->findById($_GET['category']);
            $jokes = $category->getJokes(10, $offSet);
            $totalJokes = $category->getNumJokes();
        } else {
            $jokes = $this->jokesTable->findAll('jokedate DESC', 10, $offSet);
            $totalJokes = $this->jokesTable->total();
        }

    $title = 'Joke list';

    $author = $this->authentication->getUser();

    return ['template' => 'jokes.html.php',
            'title' => $title,
            'variables' => [
                'totalJokes' => $totalJokes,
                'jokes' => $jokes,
                'user' => $author,
                'categories' => $this->categoriesTable->findAll(),
                'currentPage' => $page,
                'category' => $_GET['category'] ?? null
                ]
            ];
    }

    public function home() {
        $title = 'Internet Joke Database';
        return ['template' => 'home.html.php', 'title' => $title];
    }

    public function delete() {
        $author = $this->authentication->getUser();
        $joke = $this->jokesTable->findById($_POST['id']);

        if ($joke->authorId != $author->id && !$author->hasPermission(\Jokerdb\Entity\Author::DELETE_JOKES)) {
            return;
        }

        $this->jokesTable->delete($_POST['id']);

        header('location: /joke/list');
    }

    public function saveEdit() {
        $author = $this->authentication->getUser();

        $joke = $_POST['joke'];
        $joke['jokedate'] = new \DateTime();

        $jokeEntity = $author->addJoke($joke);
        $jokeEntity->clearCategories(); //  remove every record from the joke_category table that represents the joke stored in $joke

        foreach ($_POST['category'] as $categoryId) {
            $jokeEntity->addCategory($categoryId);
        }

        header('location: /joke/list');
    }

    public function edit() {
        $author = $this->authentication->getUser();
        $categories = $this->categoriesTable->findAll();

            if (isset($_GET['id'])) {
                $joke = $this->jokesTable->findById($_GET['id']);
            }

            $title = 'Edit joke';

            return ['template'  => 'editJoke.html.php',
                    'title'     => $title,
                    'variables' => [
                        'joke'       => $joke ?? null,
                        'user' => $author,
                        'categories' => $categories
                ]];
    }
}