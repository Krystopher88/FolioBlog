<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Comments;
use App\Entity\Projects;
use App\Entity\Categorys;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ProjectsFixtures extends Fixture
{
    public function load(ObjectManager $objectManager)
    {
        $faker = Factory::create('fr_FR');

        $categorysReference = $objectManager->getRepository(Categorys::class)->findAll();
        $commentsReference = $objectManager->getRepository(Comments::class)->findAll();

        for ($p = 1; $p <= 10; ++$p)
        {
            $project = new Projects();
            $project->setName($faker->sentence(3));
            $project->setContent($faker->text(200));
            $isPublish = (bool)rand(0, 1);
            $project->setIsPublish($isPublish);

            for ($ca = 1; $ca <= 2; ++$ca){
                if (!empty($categorysReference)){
                    $project->addCategory($faker->randomElement($categorysReference));
                }
            }

            for ($co = 1; $co <= 3; ++$co){
                if (!empty($commentsReference)){
                    $project->addComment($faker->randomElement($commentsReference));
                }
            }
            $objectManager->persist($project);
        }
        $objectManager->flush();
    }
}