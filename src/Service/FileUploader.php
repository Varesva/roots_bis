<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class FileUploader
{
    private $targetDirectory;
    private $recommendDir;
    private $contactDir;
    private $contentRootsDir;
    private $slugger;

    public function __construct($targetDirectory, $contentRootsDir, $contactDir, $recommendDir, SluggerInterface $slugger)
    {
        $this->targetDirectory = $targetDirectory;
        $this->contentRootsDir = $contentRootsDir;
        $this->contactDir = $contactDir;
        $this->recommendDir = $recommendDir;
        $this->slugger = $slugger;
    }

    public function upload(UploadedFile $file, $directory)
    {
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

        $safeFilename = $this->slugger->slug($originalFilename);

        $newFilename = $safeFilename . '-' . uniqid() . '.' . $file->guessExtension();

        try {
            switch ($directory) {
                case 'recommend':
                    
                    $file->move($this->getRecommendDir(), $newFilename);
                    echo 'envoyé dans le dossier recommend';
                    break;

                case 'contact':
                    $file->move($this->getContactDir(), $newFilename);
                    break;

                case 'content':
                    $file->move($this->getContentRootsDir(), $newFilename);
                    break;

                default:
                    $file->move($this->getTargetDirectory(), $newFilename);
            }
        } catch (FileException $e) {
            // ... handle exception if something happens during file upload
            // echo 'Oops, une erreur semble s\'être produite';
            // return null;
        }
        return $newFilename;
    }

    public function getTargetDirectory()
    {
        return $this->targetDirectory;
    }

    public function getRecommendDir()
    {
        return $this->recommendDir;
    }

    public function getContactDir()
    {
        return $this->contactDir;
    }

    public function getContentRootsDir()
    {
        return $this->contentRootsDir;
    }
}
