<?php

namespace App\DataFixtures;

use App\Entity\Projects;
use App\Entity\Posts;
use App\Entity\Users;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Faker\Factory;


class UsersFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $userPasswordHasherInterface)
    {
    }

    public function load(ObjectManager $objectManager): void
    {
        $faker = Factory::create('fr_FR');

        $postsRefererence = $objectManager->getRepository(Posts::class)->findAll();
        $projectsReference = $objectManager->getRepository(Projects::class)->findAll();

        $admin = new Users();
        $admin->setEmail('hello@krystdev.fr');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setPassword($this->userPasswordHasherInterface->hashPassword($admin, 'admin'));
        $admin->setFirstName('Christopher');
        $admin->setLastName('Bichon');
        $admin->setNickName('KrystDev');

        for ($project = 1; $project <= 5; ++$project){
            $admin->addProject($faker->randomElement($projectsReference));
        }

        for ($posts = 1; $posts <= 5; ++$posts){
            $admin->addPost($faker->randomElement($postsRefererence));
        }

        $objectManager->persist($admin);

        $objectManager->flush();
    }
}
