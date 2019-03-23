<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 11.03.2019
 * Time: 23:40
 */

namespace shop\services;


use yii\rbac\ManagerInterface;

class RoleManager
{
    public $manager;

    public function __construct(ManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    public function assign($userId, $role)
    {
        if (!$role = $this->manager->getRole($role)) {
            throw new \DomainException('Role "' . $role . '" does not exist.');
        }
        $this->manager->revokeAll($userId);
        $this->manager->assign($role, $userId);
    }
}