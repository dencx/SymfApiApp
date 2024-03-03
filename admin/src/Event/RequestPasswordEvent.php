<?php

namespace App\Event;

use App\Entity\User;
use Symfony\Contracts\EventDispatcher\Event;

class ResetPasswordRequestEvent extends Event
{
    public const NAME = 'reset.password.requested';
    public function __construct(User $user)
    {
        $this->user = $user;
    }
    public function getUser()
    {
        return $this->user;
    }
}
