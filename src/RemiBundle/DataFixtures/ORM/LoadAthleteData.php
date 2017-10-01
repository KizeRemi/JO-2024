<?php
/**
 * Created by PhpStorm.
 * User: remimavillaz
 * Date: 01/10/2017
 * Time: 18:28
 */
namespace RemiBundle\DataFixtures\ORM;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use RemiBundle\Entity\Athlete;
use RemiBundle\DataFixtures\ORM\LoadDisciplineData;
use RemiBundle\DataFixtures\ORM\LoadPaysData;

class LoadAthleteData extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $athletes = [
            [
                'nom'            => 'Mavillaz',
                'prenom'         => 'Rémi',
                'date_naissance' => new \DateTime('1990-05-29'),
                'photo'          => 'photo2.png',
                'pays'           => 'France'
            ],
            [
                'nom'            => 'Lacouture',
                'prenom'         => 'Ludovic',
                'date_naissance' => new \DateTime('1995-06-28'),
                'photo'          => 'photo1.jpeg',
                'pays'           => 'Inde'
            ]
        ];

        foreach ($athletes as $athlete) {
            $object = new Athlete();
            $object->setNom($athlete['nom']);
            $object->setPrenom($athlete['prenom']);
            $object->setDateNaissance($athlete['date_naissance']);
            $object->setDiscipline($this->getReference('discipline-Cyclisme'));
            $object->setPays($this->getReference('drapeau-'.$athlete['pays']));
            $file = new UploadedFile($this->container->getParameter('photos_directory') ."/". $athlete['photo'], 'Image1', null, null, null, true);
            $object->setPhoto($file);
            $manager->persist($object);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            LoadDisciplineData::class,
            LoadPaysData::class,
        );
    }
}