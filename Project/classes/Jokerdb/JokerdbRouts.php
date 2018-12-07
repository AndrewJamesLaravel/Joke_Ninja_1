<?php

namespace Jokerdb;

class JokerdbRouts {

    public function callAction($route) {
        include __DIR__ . '/../../includes/DatabaseConnection.php';

        $jokesTable = new \Ninja\DatabaseTable($pdo, 'joke', 'id');
        $authorsTable = new \Ninja\DatabaseTable($pdo, 'author', 'id');

        if ($route === 'joke/list') {
            $controller = new \Jokerdb\Controllers\Joke($jokesTable, $authorsTable);
            $page = $controller->list();
        } elseif ($route === '') {
            $controller = new \Jokerdb\Controllers\Joke($jokesTable, $authorsTable);
            $page = $controller->home();
        } elseif ($route === 'joke/edit') {
            $controller = new \Jokerdb\Controllers\Joke($jokesTable, $authorsTable);
            $page = $controller->edit();
        } elseif ($route === 'joke/delete') {
            $controller = new \Jokerdb\Controllers\Joke($jokesTable, $authorsTable);
            $page = $controller->delete();
        } elseif ($route === 'register') {
            $controller = new \Jokerdb\Controllers\Register($authorsTable);
            $page = $controller->showForm();
        }
        return $page;
    }
}