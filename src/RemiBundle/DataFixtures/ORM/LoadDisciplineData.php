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
use RemiBundle\Entity\Discipline;

class LoadDisciplineData extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $disciplines = array(
            'Tir à l\'arc',
            'Cyclisme',
            'Badmin',
            'Volley ball',
            'Handball',
            'Basketball',
            'Peche',
            'Natation'
        );
        foreach ($disciplines as $discipline) {
            $object = new Discipline();
            $object->setNom($discipline);
            $this->addReference('discipline-'.$object->getNom(), $object);
            $manager->persist($object);
        }
        $manager->flush();
    }
}
