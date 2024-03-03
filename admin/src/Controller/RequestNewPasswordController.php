<?php

namespace App\Controller;

use App\Entity\LostPassword;
use App\Entity\User;
use App\Event\ResetPasswordRequestEvent;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

class RequestNewPasswordController extends AbstractController
{

    public function __construct(EventDispatcherInterface $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    public function __invoke(LostPassword $data)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $repository = $entityManager->getRepository(User::class);
        $user = $repository->findOneBy(['email' => $data->getEmail()]);
        if ($user) {
            $user->setLostPassword($data);
            $entityManager->flush();

            $dispatcher = $this->eventDispatcher;
            $event = new ResetPasswordRequestEvent($user);
            $dispatcher->dispatch($event, ResetPasswordRequestEvent::NAME);
        } else {
            exit();
        }
        return new JsonResponse($user->getId());
    }
}
