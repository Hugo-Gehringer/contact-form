<?php

namespace App\Service;

use App\Entity\ContactForm;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Serializer\SerializerInterface;

class ContactFormJson
{
    public function serializeToJsonFile(SerializerInterface $serializer, ContactForm $contactForm, string $pathToJsonFiles): void
    {
        $jsonData = $serializer->serialize($contactForm, 'json');
        $filesystem = new Filesystem();
        $pathJsonFile = $pathToJsonFiles . '/' . $contactForm->getEmail() . time();
        try {
            if (!$filesystem->exists($pathToJsonFiles)) {
                $filesystem->mkdir($pathToJsonFiles);
            }
            $filesystem->dumpFile($pathJsonFile, $jsonData);
        } catch (IOExceptionInterface $exception) {
            echo "An error occurred while creating your directory at " . $exception->getPath();
        }
    }
}