<?php

namespace App\DataFixtures;

use App\Entity\ContactDetail;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }


    public function load(ObjectManager $manager): void
    {
        $baseUser = new User();
        $baseUserContactDetail = new ContactDetail();
        $baseUserContactDetail->setFirstname('Test');
        $baseUserContactDetail->setLastname('User');
        $baseUser->setContactDetail($baseUserContactDetail);
        $baseUser->setRoles(['ROLE_USER']);
        $baseUser->setEmail('test@email.com');
        $password = $this->hasher->hashPassword($baseUser, '123');
        $baseUser->setPassword($password);

        $admin = new User();
        $adminContactDetail = new ContactDetail();
        $adminContactDetail->setFirstname('Test');
        $adminContactDetail->setLastname('Admin');
        $admin->setContactDetail($adminContactDetail);
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setEmail('admin@email.com');
        $password = $this->hasher->hashPassword($baseUser, '123');
        $admin->setPassword($password);

        $manager->persist($baseUser);
        $manager->persist($admin);
        $manager->flush();
    }
}
