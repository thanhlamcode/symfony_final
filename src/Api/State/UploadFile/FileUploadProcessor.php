<?php

namespace App\Api\State\UploadFile;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\UploadedFile;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile as SymfonyUploadedFile;
use Symfony\Component\HttpFoundation\RequestStack;

class FileUploadProcessor implements ProcessorInterface
{
    public function __construct(
        private EntityManagerInterface $em,
        private RequestStack $requestStack,
    ) {}

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): UploadedFile
    {
        $request = $this->requestStack->getCurrentRequest();
        $uploadedFile = $request->files->get('file');

        if (!$uploadedFile instanceof SymfonyUploadedFile) {
            throw new \RuntimeException('No valid file uploaded.');
        }

        $fileEntity = new UploadedFile();
        $fileEntity->setFile($uploadedFile);

        $this->em->persist($fileEntity);
        $this->em->flush();

        return $fileEntity;
    }
}
