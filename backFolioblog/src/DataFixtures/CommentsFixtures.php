<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Posts;
use App\Entity\Comments;
use App\Entity\Projects;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class CommentsFixtures extends Fixture
{
    public function load(ObjectManager $objectManager)
    {
        $faker = Factory::create('fr_FR');

        // $postReference = $objectManager->getRepository(Posts::class)->findAll();
        // $projectsReference = $objectManager->getRepository(Projects::class)->findAll();

        for ($c = 1; $c <=40; ++$c)
        {
            $comment = new Comments();
            $comment->setUserName($faker->lastName);
            $comment->setContent($faker->sentence(2));

            $objectManager->persist($comment);
        }
        $objectManager->flush($comment);
    }
}