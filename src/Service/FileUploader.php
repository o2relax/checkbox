<?php

namespace App\Service;

use Psr\Log\LoggerInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

readonly class FileUploader
{
    public function __construct(
        private string           $targetDirectory,
        private SluggerInterface $slugger,
        private Filesystem       $filesystem,
        private LoggerInterface $logger
    )
    {
    }

    public function upload(UploadedFile $file): ?string
    {
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $fileName = $this->slugger->slug($originalFilename) . '-' . uniqid() . '.' . $file->guessExtension();

        try {
            $file->move($this->getTargetDirectory(), $fileName);
        } catch (FileException $e) {
            $this->logger->error('Cant upload file', ['targetDirectory' => $this->getTargetDirectory(), 'file' => $file, 'filename' => $fileName, 'exception' => $e]);

            return null;
        }

        return $fileName;
    }

    public function remove(string $fileName): void
    {
        try {
            $this->filesystem->remove(implode('/', [$this->getTargetDirectory(), $fileName]));
        } catch (FileException $e) {
            $this->logger->error('Cant delete file', ['targetDirectory' => $this->getTargetDirectory(), 'filename' => $fileName, 'exception' => $e]);
        }
    }

    public function getTargetDirectory(): string
    {
        return $this->targetDirectory;
    }
}