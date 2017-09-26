<?php

namespace RemiBundle\Listener;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use RemiBundle\Entity\Pays;
use RemiBundle\Services\FileUploader;

class DrapeauUploaderListener
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
        if (!$entity instanceof Pays) {
            return;
        }
        
        $oldPathFile = $args->getOldValue('drapeau');
        if($oldPathFile){
            $this->uploader->remove($oldPathFile);
        }

        $this->uploadFile($entity);
    }

    private function uploadFile($entity)
    {
        if (!$entity instanceof Pays) {
            return;
        }

        $file = $entity->getDrapeau();
        if ($file instanceof UploadedFile) {
            $fileName = $this->uploader->upload($file);
        }

        $entity->setDrapeau($fileName);
    }

    public function postRemove(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        if ($entity instanceof Pays) {
            $this->uploader->remove($entity->getDrapeau());
        }
    }
}
