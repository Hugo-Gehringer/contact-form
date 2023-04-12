<?php

namespace App\Form;

use App\Entity\ContactDetail;
use App\Entity\ContactForm;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        /** @var User $user */
        $user = $options['user'];
        $contactDetail = $user?->getContactDetail();
        $builder
            ->add('email', EmailType::class, [
                'data' => $user?->getEmail()
            ])
            ->add('contactDetail', ContactDetailType::class, [
                'firstname'=> $contactDetail?->getFirstname(),
                'lastname'=> $contactDetail?->getLastname()
            ])
            ->add('question', TextareaType::class, [
                'label' => 'Votre question'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ContactForm::class,
            'user' => null
        ]);
    }
}
