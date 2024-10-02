<?php

namespace Geekbrains\Application1\Domain\Controllers;

use Geekbrains\Application1\Application\Application;
use Geekbrains\Application1\Application\Render;
use Geekbrains\Application1\Application\Auth;
use Geekbrains\Application1\Domain\Models\User;

class UserController extends AbstractController
{

    protected array $actionsPermissions = [
        'actionHash' => ['admin'],
        'actionSave' => ['admin'],
        'actionEdit' => ['admin'],
        'actionIndex' => ['admin'],
        'actionLogout' => ['admin'],
    ];

    public function actionIndex()
    {
        $users = User::getAllUsersFromStorage();

        $render = new Render();

        if (!$users) {
            return $render->renderPage(
                'user-empty.tpl',
                [
                    'title' => 'Список пользователей в хранилище',
                    'message' => "Список пуст или не найден"
                ]
            );
        } else {
            return $render->renderPage(
                'user-index.tpl',
                [
                    'title' => 'Список пользователей в хранилище',
                    'users' => $users
                ]
            );
        }
    }

    public function actionSave(): string
    {
        if (User::validateRequestData()) {
            $user = new User();
            $user->setParamsFromRequestData();
            $user->saveToStorage();
            $render = new Render();

            return $render->renderPage(
                'user-created.tpl',
                [
                    'title' => 'Пользователь создан',
                    'message' => "Создан пользователь " . $user->getUserName() . " " . $user->getUserLastName()
                ]
            );
        } else {
            $render = new Render();
            return $render->renderPageWithForm(
                'user-index.tpl',
                [
                    'title' => "Введены некорректные данные"
                ]
            );
        }
    }

    public function actionEdit(): string
    {
        $render = new Render();

        return $render->renderPageWithForm(
            'user-create.tpl',
            [
                'title' => 'Форма создания пользователя'
            ]
        );
    }

    public function actionUpdate(): string
    {
        if (User::validateRequestData()) {
            $arrayData = [];

            // var_dump($_POST['name']);
            // echo '<br>';
            if (isset($_POST['name'])) {
                $arrayData['user_name'] = $_POST['name'];
            }
            if (isset($_POST['lastname'])) {
                $arrayData['user_lastname'] = $_POST['lastname'];
            }
            // var_dump(isset($_POST['birthday']) . " - дата рождения");
            // echo '<br>';
            // var_dump($_POST['birthday'] . 'Такое день рождения');
            // echo '<br>';
            if (isset($_POST['birthday'])) {
                $arrayData['user_birthday_timestamp'] = strtotime($_POST['birthday']);

            }

            User::updateUser($_GET['id'], $arrayData);
            // echo "pre";
            // echo '<br>';
            var_dump($_GET['id'] . "Это мы в GET['id'] получаем");
            $str = 'Данные пользователя ' . $_POST['name'] . ' обновлены';


            $render = new Render();
            return $render->renderPageWithForm(
                'user-index.tpl',
                [
                    'title' => $str
                ]
            );
        } else {

            $render = new Render();
            return $render->renderPageWithForm(
                'user-index.tpl',
                [
                    'title' => "Произошла какая-то ошибка"
                ]
            );
        }
    }

    public function actionChange(): string
    {

        $render = new Render();
        return $render->renderPage(
            'user-update.tpl',
            [
                'title' => 'Пользователь обновлен',
                'message' => "Обновлен пользователь ",
                'userId' => $_GET['id']
            ]
        );

    }

    public function actionDelete(): string
    {
        if (User::exists($_GET['id'])) {
            User::deleteFromStorage($_GET['id']);

            $render = new Render();

            return $render->renderPage(
                'user-removed.tpl',
                []
            );
        } else {
            throw new \Exception("Пользователь не существует");
        }
    }

    public function actionAuth(): string
    {
        $render = new Render();

        return $render->renderPageWithForm(
            'user-auth.tpl',
            [
                'title' => 'Форма логина'
            ]
        );
    }

    public function actionHash(): string
    {
        return Auth::getPasswordHash($_GET['pass_string']);
    }
    public function actionLogin(): string
    {
        $result = false;

        // print_r($_POST['password']);

        if (isset($_POST['user_login']) && isset($_POST['password'])) {
            $result = Application::$auth->proceedAuth($_POST['user_login'], $_POST['password']);

            if (isset($_POST['user-remember'])) {
                $token = Auth::generateToken();
                User::setToken($_POST['user_login']);
            }
            // еще один if дописать что если в post есть user-remember и тогда мы генерируем токен смотри Auth
            // добавить в базу данных и в сессию и метод должен быть в User

            // нужен будет еще один метод который будет проверять токен, возвращать да/нет
        }
        // var_dump($result);
        if (!$result) {
            $render = new Render();

            return $render->renderPageWithForm(
                'user-auth.tpl',
                [
                    'title' => 'Форма логина',
                    'auth_success' => false,
                    'auth_error' => 'Неверные логин или пароль'
                ]
            );
        } else {
            header('Location: /');
            return "";
        }
    }
    public function actionLogout(): void
    {
        session_destroy();
        unset($_SESSION['user_name']);
        unset($_SESSION['user_id']);
        unset($_SESSION['user_lastname']);
        unset($_SESSION['csrf_token']);
        // дписать и для user_id
        header("Location: /");
        die();
    }
}