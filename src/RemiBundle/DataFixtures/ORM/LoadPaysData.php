<?php
/**
 * Created by PhpStorm.
 * User: remimavillaz
 * Date: 01/10/2017
 * Time: 19:29
 */

namespace RemiBundle\DataFixtures\ORM;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use RemiBundle\Entity\Pays;

class LoadPaysData extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $quelquesPays = [
            [
                'nom'            => 'France',
                'drapeau'          => 'france.png'
            ],
            [
                'nom'            => 'Inde',
                'drapeau'          => 'inde.png'
            ],
        ];

        foreach ($quelquesPays as $pays) {
            $object = new Pays();
            $object->setNom($pays['nom']);
            $file = new UploadedFile($this->container->getParameter('drapeaux_directory') ."/". $pays['drapeau'], 'Image1', null, null, null, true);
            $object->setDrapeau($file);
            $this->addReference('drapeau-'.$object->getNom(), $object);
            $manager->persist($object);
        }
        $manager->flush();
    }
}
