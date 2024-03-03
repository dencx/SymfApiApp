<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
// use Symfony\Component\Routing\Annotation\Route;

use App\Entity\User;
use App\Entity\LostPassword;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\Response;


class ResetPasswordController extends AbstractController
{

    public function __invoke(Request $request, User $user, UserPasswordEncoderInterface $encoder)
    {
        //TODO: remove this
        $entityManager = $this->getDoctrine()->getManager();
        $user = $entityManager->getRepository(User::class)->find($request->attributes->get('id'));

        if ($request->get('token') === $user->getLostPassword()->getToken()) {
            // $entityManager = $this->getDoctrine()->getManager();

            $user->setPassword($encoder->encodePassword($user, $request->get('password')));

            $repository = $this->getDoctrine()->getRepository(LostPassword::class);
            $item = $repository->find($user->getLostPassword()->getId());

            $entityManager->persist($user);
            $entityManager->flush();


            $entityManager->remove($item);
            $entityManager->flush();

            return new Response(sprintf('User password %s successfully updated', $user->getUsername()));
        }

        return new Response(sprintf('Invalid data'));
    }
}
