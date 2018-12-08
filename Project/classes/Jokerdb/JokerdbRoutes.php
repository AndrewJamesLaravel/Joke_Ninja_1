<?php

namespace Jokerdb;

class JokerdbRoutes implements \Ninja\Routes
{

    public function getRoutes()
    {
        include __DIR__ . '/../../includes/DatabaseConnection.php';

        $jokesTable = new \Ninja\DatabaseTable($pdo, 'joke', 'id');
        $authorsTable = new \Ninja\DatabaseTable($pdo, 'author', 'id');

        $jokeController = new \Jokerdb\Controllers\Joke($jokesTable, $authorsTable);

        $routes = [
            'joke/edit' => [
                'POST' => [
                    'controller' => $jokeController,
                    'action' => 'saveEdit'
                ],
                'GET' => [
                    'controller' => $jokeController,
                    'action' => 'edit'
                ]
            ],
            'joke/delete' => [
                'POST' => [
                    'controller' => $jokeController,
                    'action' => 'delete'
                ]
            ],
            'joke/list' => [
                'GET' => [
                    'controller' => $jokeController,
                    'action' => 'list'
                ]
            ],
            '' => [
                'GET' => [
                    'controller' => $jokeController,
                    'action' => 'home'
                ]
            ]
        ];

        return $routes;

        /*if ($route === 'joke/list') {
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
        return $page;*/
    }
}