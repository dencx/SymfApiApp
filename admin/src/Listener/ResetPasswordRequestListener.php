<?php

namespace App\Listener;

use Symfony\Contracts\EventDispatcher\Event;

class ResetPasswordRequestListener
{
    public function __construct(\Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function onResetPasswordRequestedAction(Event $event)
    {
        $user_id = $event->getUser()->getId();
        $message = (new \Swift_Message('New password request'))
            ->setFrom('admin@example.com')
            ->setTo('user@example.com')->setBody(
                'You requested a new password. Use this link to reset your password: http://localhost:8000/api/users/' . $user_id . '/change-password?token=' . $event->getUser()->getLostPassword()->getToken() . '&password=here_new_password'
            );

        $this->mailer->send($message);
    }
}
