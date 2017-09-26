<?php

namespace RemiBundle\Listener;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use RemiBundle\Entity\Athlete;
use RemiBundle\Services\FileUploader;

class PhotoUploaderListener
{
    private $uploader;

    public function __construct(FileUploader $uploader)
    {
        $this->uploader = $uploader;
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        $this->uploadFile($entity);
    }

    public function preUpdate(PreUpdateEventArgs $args)
    {
        $entity = $args->getEntity();
        if (!$entity instanceof Athlete) {
            return;
        }

        $oldPathFile = $args->getOldValue('photo');
        if($oldPathFile){
            $this->uploader->remove($oldPathFile);
        }

        $this->uploadFile($entity);
    }

    private function uploadFile($entity)
    {
        if (!$entity instanceof Athlete) {
            return;
        }

        $file = $entity->getPhoto();
        if ($file instanceof UploadedFile) {
            $fileName = $this->uploader->upload($file);
        }

        $entity->setPhoto($fileName);
    }

    public function postRemove(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        if ($entity instanceof Athlete) {
            $this->uploader->remove($entity->getPhoto());
        }
    }
}