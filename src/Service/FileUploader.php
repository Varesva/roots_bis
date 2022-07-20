<?php

namespace App\Service;
// src/Service/FileUploader.php - https://symfony.com/doc/current/controller/upload_file.html#creating-an-uploader-service -- 
// création du dossier virtuel qui contient nos services
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class FileUploader
{
    private $targetDirectory;
    private $slugger;

    public function __construct($targetDirectory, SluggerInterface $slugger)
    {
        // chemin vers le fichier de stockage des images (lié à config>service.yaml)
        $this->targetDirectory = $targetDirectory;
        $this->slugger = $slugger;
    }

    // FAIRE L'UPLOAD D'IMAGE
    public function upload(UploadedFile $file)
    {
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

        $safeFilename = $this->slugger->slug($originalFilename);

        $fileName = $safeFilename . '-' . uniqid() . '.' . $file->guessExtension();

        try {
            
            $file->move($this->getTargetDirectory(), $fileName);
        } 

        catch (FileException $e) {
            // ... handle exception if something happens during file upload
            // return null; // for example

            return 'Un problème est survenu. Veuillez réessayez s\'il-vous-plait';
        }

        return $fileName;
    }

    public function getTargetDirectory()
    {
        return $this->targetDirectory;
    }
}
