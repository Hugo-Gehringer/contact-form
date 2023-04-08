<?php

namespace App\Controller;

use App\Entity\ContactForm;
use App\Form\ContactFormType;
use App\Repository\ContactFormRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Path;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class ContactFormController extends AbstractController
{
    #[Route('/contact/form', name: 'app_contact_form')]
    public function index(ContactFormRepository $contactFormRepository): Response
    {
        $contactForms = $contactFormRepository->findAll();
        return $this->render('contact_form/index.html.twig', [
            'controller_name' => 'ContactFormController',
            'contactForms' => $contactForms
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
            $contactFormRepository->save($contactForm,true);
            $jsonData = $serializer->serialize($contactForm, 'json');
            $filesystem = new Filesystem();
            $pathToJsonFiles = Path::normalize($this->getParameter('kernel.project_dir').$this->getParameter('contact.form.json.directory'));
            $pathJsonFile = $pathToJsonFiles.'/'.$contactForm->getEmail().time();
            try {
                if (!$filesystem->exists($pathToJsonFiles)) {
                    $filesystem->mkdir($pathToJsonFiles);
                }
                $filesystem->dumpFile($pathJsonFile, $jsonData);
                $this->addFlash('success', 'Votre demande de contact à bien été prise en compte.');
            } catch (IOExceptionInterface $exception) {
                echo "An error occurred while creating your directory at ".$exception->getPath();
            }
            if ($this->isGranted('ROLE_USER'))
                return $this->redirectToRoute('app_user',['user'=>$this->getUser()->getId()]);
            return $this->redirectToRoute('app_main');
        }

        return $this->render('contact_form/newContactForm.html.twig', [
            'controller_name' => 'ContactFormNew',
            'contactForm' => $form->createView(),

        ]);
    }
}
