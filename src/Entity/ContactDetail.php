<?php

namespace App\Entity;

use App\Repository\ContactDetailRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ContactDetailRepository::class)]
class ContactDetail
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 40)]
    private ?string $firstname = null;

    #[ORM\Column(length: 40)]
    private ?string $lastname = null;

    #[ORM\OneToOne(mappedBy: 'contactDetail', cascade: ['persist', 'remove'])]
    private ?User $user = null;

    #[ORM\OneToOne(mappedBy: 'contactDetail', cascade: ['persist', 'remove'])]
    private ?ContactForm $contactForm = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        // set the owning side of the relation if necessary
        if ($user->getContactDetail() !== $this) {
            $user->setContactDetail($this);
        }

        $this->user = $user;

        return $this;
    }

    public function getContactForm(): ?ContactForm
    {
        return $this->contactForm;
    }

    public function setContactForm(ContactForm $contactForm): self
    {
        // set the owning side of the relation if necessary
        if ($contactForm->getContactDetail() !== $this) {
            $contactForm->setContactDetail($this);
        }

        $this->contactForm = $contactForm;

        return $this;
    }
}
