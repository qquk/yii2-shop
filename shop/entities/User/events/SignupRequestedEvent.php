<?php
namespace shop\entities\User\events;

use shop\entities\User\User;

class SignupRequestedEvent
{
    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }
}