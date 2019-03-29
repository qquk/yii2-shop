<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 18.04.2018
 * Time: 00:06
 */

namespace shop\services\auth;


use shop\entities\User;
use shop\repositories\UserRepository;

class NetworkService
{
    private $users;
    public function __construct(UserRepository $users)
    {
        $this->users = $users;
    }

    public function auth($identity, $network){
        if($user = $this->users->findByNetworkIdentity($network, $identity)){
            return $user;
        }
        $user = User::signupByNetwork($network, $identity);
        $this->users->save($user);
        return $user;

    }

    public function attach($id, $network, $identity){
        if($user = $this->users->findByNetworkIdentity($network, $identity)){
            throw new \DomainException("Networ is allready signed up");
        }

        $user = $this->users->get($id);

        $user->attachNetwork($network, $identity);
        $this->users->save($user);
    }

}