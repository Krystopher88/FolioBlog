<?php

namespace App\DataFixtures;

use App\Entity\Categorys;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategorysFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $categorys = [
            'HTML',
            'CSS',
            'JavaScript',
            'PHP',
            'Symfony',
            'VueJS',
            'TailwindCSS',
            'Bootstrap',
            'Docker',
            'Debian',
            'Bonne Pratique',
            'Git',
            'GitHub',
            'Outils',
        ];

        foreach ($categorys as $category) {
            $categorys = new Categorys();
            $categorys->setName($category);
            // $categorys->setSlug($category);

            $manager->persist($categorys);
        }
        $manager->flush();
    }
}
