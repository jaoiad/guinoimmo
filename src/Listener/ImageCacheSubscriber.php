<?php

namespace App\Listener;


use App\Entity\Location;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;

//suprime les images en caches lorqu'on supprime une location
class ImageCacheSubscriber implements EventSubscriber{

    /**
     * @var CacheManager
     */
    private $cacheManager;

    /**
     * @var UploadHelper
     */
    private $uploaderHelper;


    public function __construct(CacheManager $cacheManager, UploaderHelper $uploaderHelper)
    {
        $this->cacheManager= $cacheManager;
        $this->uploaderHelper=$uploaderHelper;
    }

    public function getSubscribedEvents()
    {
       return [
            'preRemove',
            'preUpdate'

       ];
    }

    public function preRemove(LifecycleEventArgs $args){
        $entity = $args->getEntity();
        if(!$entity instanceof Location){
            return;
        }
        $this->cacheManager->remove($this->uploaderHelper->asset($entity, 'imageFile'));
    }

    public function preUpdate(PreUpdateEventArgs $args){
        $entity = $args->getEntity();
        if (!$entity instanceof Location) {
            return;
        }
        if($entity->getImageFile() instanceof UploadedFile){
        $this->cacheManager->remove($this->uploaderHelper->asset($entity, 'imageFile'));
          
    }
    }
    

}
