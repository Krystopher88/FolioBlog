<?php

namespace App\DataFixtures;

use App\Entity\Categorys;
use App\Entity\Comments;
use Faker\Factory;
use App\Entity\Posts;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class PostsFixtures extends Fixture
{
    public function load(ObjectManager $objectManager)
    {
        $faker = Factory::create('fr_FR');

        $categorysReference = $objectManager->getRepository(Categorys::class)->findAll();
        $commentsReference = $objectManager->getRepository(Comments::class)->findAll();

        for ($p = 1; $p <=10; ++$p)
        {
            $posts = new Posts();
            $posts->setName($faker->sentence(3));
            $posts->setContent($faker->text(200));
            $isPublish = (bool) rand(0, 1);
            $posts->setIsPublish($isPublish);

            for ($ca = 1; $ca <= 2; ++$ca){
                if (!empty($categorysReference)){
                    $posts->addCategory($faker->randomElement($categorysReference));
                }
                
            }

            for ($co = 1; $co <= 3; ++$co){
                if (!empty($commentsReference)){
                    $posts->addComment($faker->randomElement($commentsReference));
                }
                
            }
            $objectManager->persist($posts);
        }
        $objectManager->flush();
    }
}