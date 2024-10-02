<?php

namespace Geekbrains\Application1\Domain\Controllers;

use Geekbrains\Application1\Application\Application;
use Geekbrains\Application1\Domain\Models\User;

class AbstractController extends Controller {

    protected array $actionsPermissions = [];
    
    public function getUserRoles(): array{
        $roles = [];
        $roles[] = 'user';
            // - переместить это в модель User, и назвать getUserRoleById статичный
        // if(isset($_SESSION['id_user'])){
        //     $rolesSql = "SELECT * FROM user_roles WHERE id_user = :id";

        //     $handler = Application::$storage->get()->prepare($rolesSql);
        //     $handler->execute(['id' => $_SESSION['id_user']]);
        //     $result = $handler->fetchAll();
    
        //     if(!empty($result)){
        //         foreach($result as $role){
        //             $roles[] = $role['role'];
        //         }
        //     }
        // }
        $roles = User::getUserRoleById($roles);
        return $roles;
    }

    public function getActionsPermissions(string $methodName): array {
        return $this->actionsPermissions[$methodName] ?? [];
    }
}