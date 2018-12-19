<?php

namespace Jokerdb;

class JokerdbRoutes implements \Ninja\Routes
{

    private $authorsTable;
    private $jokesTable;
    private $categoriesTable;
    private $jokeCategoriesTable;
    private $authentication;

    public function __construct()
    {
        include __DIR__ . '/../../includes/DatabaseConnection.php';

        $this->jokesTable = new \Ninja\DatabaseTable($pdo, 'joke', 'id',
            '\Jokerdb\Entity\Joke', [&$this->authorsTable, &$this->jokeCategoriesTable]);
        $this->authorsTable = new \Ninja\DatabaseTable($pdo, 'author', 'id',
            '\Jokerdb\Entity\Author', [&$this->jokesTable]);
        $this->categoriesTable = new \Ninja\DatabaseTable($pdo, 'category', 'id',
            '\Jokerdb\Entity\Category', [&$this->jokesTable, &$this->jokeCategoriesTable]);
        $this->jokeCategoriesTable = new \Ninja\DatabaseTable($pdo, 'joke_category', 'categoryId');
        $this->authentication = new \Ninja\Authentication($this->authorsTable,
            'email', 'password');
    }

    public function getRoutes(): array
    {
        $jokeController = new \Jokerdb\Controllers\Joke($this->jokesTable, $this->authorsTable,
            $this->categoriesTable, $this->authentication);
        $authorController = new \Jokerdb\Controllers\Register($this->authorsTable);
        $loginController = new \Jokerdb\Controllers\Login($this->authentication);
        $categoryController = new \Jokerdb\Controllers\Category($this->categoriesTable);

        $routes = [
            'author/register' => [
              'GET' => [
                  'controller' => $authorController,
                  'action' => 'registrationForm'
              ],
                'POST' => [
                    'controller' => $authorController,
                    'action' => 'registerUser'
                ]
            ],
            'author/success' => [
              'GET' => [
                  'controller' => $authorController,
                  'action' => 'success'
              ]
            ],
            'joke/edit' => [
                'POST' => [
                    'controller' => $jokeController,
                    'action' => 'saveEdit'
                ],
                'GET' => [
                    'controller' => $jokeController,
                    'action' => 'edit'
                ],
                'login' => true
            ],
            'joke/delete' => [
                'POST' => [
                    'controller' => $jokeController,
                    'action' => 'delete'
                ],
                'login' => true
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
            ],
            'login/error' => [
                'GET' => [
                    'controller' => $loginController,
                    'action' => 'error'
                ]
            ],
            'login' => [
                'GET' => [
                    'controller' => $loginController,
                    'action' => 'loginForm'
                ],
                'POST' => [
                    'controller' => $loginController,
                    'action' => 'processLogin'
                ]
            ],
            'login/success' => [
                'GET' => [
                    'controller' => $loginController,
                    'action' => 'success'
                ],
                'login' => true
            ],
            'logout' => [
                'GET' => [
                    'controller' => $loginController,
                    'action' => 'logout'
                ]
            ],
            'category/edit' => [
                'POST' => [
                    'controller' => $categoryController,
                    'action' => 'saveEdit'
                ],
                'GET' => [
                    'controller' => $categoryController,
                    'action' => 'edit'
                ],
                'login' => true
            ],
            'category/list' => [
                'GET' => [
                    'controller' => $categoryController,
                    'action' => 'list'
                ],
                'login' => true
            ],
            'category/delete' => [
                'POST' => [
                    'controller' => $categoryController,
                    'action' => 'delete'
                ],
                'login' => true
            ]
        ];

        return $routes;
    }

    public function getAuthentication(): \Ninja\Authentication
    {
        return $this->authentication;
    }
}