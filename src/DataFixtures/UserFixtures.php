<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends BaseFixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    protected function loadData(ObjectManager $manager)
    {
        $this->createMany(1, 'admin_users', function($i) {
            $user = new User();
            $user->setEmail('akim_now@mail.ru');
            $user->setFirstName('Akim');

            $user->setPassword($this->passwordEncoder->encodePassword(
                $user,
                'secret'
            ));

            return $user;
        });

        $this->createMany(10, 'main_users', function($i) {
            $user = new User();
            $user->setEmail(sprintf('user%d@example.com', $i));
            $user->setFirstName($this->faker->firstName);

            $user->setPassword($this->passwordEncoder->encodePassword(
                $user,
                'secret'
            ));

            return $user;
        });

        $manager->flush();
    }
}
