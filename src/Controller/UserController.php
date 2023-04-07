<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\ContactFormRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/user/{user}', name: 'app_user')]
    public function index(User $user, ContactFormRepository $contactFormRepository): Response
    {
        $completedForms = $contactFormRepository->findBy(['email'=>$user->getEmail()]);
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
            'completedForms' => $completedForms
        ]);
    }
}
