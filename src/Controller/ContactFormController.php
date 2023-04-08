<?php

namespace App\Controller;

use App\Entity\ContactForm;
use App\Form\ContactFormType;
use App\Repository\ContactFormRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

class ContactFormController extends AbstractController
{
    #[Route('/contact/form', name: 'app_contact_form')]
    public function index(): Response
    {
        return $this->render('contact_form/index.html.twig', [
            'controller_name' => 'ContactFormController',
        ]);
    }

    #[Route('/contact/form/new', name: 'app_contactform_new')]
    public function new(Request $request, ContactFormRepository $contactFormRepository, SerializerInterface $serializer): Response
    {
        $contactForm = new ContactForm;
        $form = $this->createForm(ContactFormType::class, $contactForm,[
            'user' => $this->getUser()
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contactFormRepository->save($contactForm);
            $jsonData = $serializer->serialize($contactForm, 'json');
            dd($jsonData);
            return $this->redirectToRoute('app_main', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('contact_form/newContactForm.html.twig', [
            'controller_name' => 'ContactFormNew',
            'contactForm' => $form->createView(),

        ]);
    }
}
