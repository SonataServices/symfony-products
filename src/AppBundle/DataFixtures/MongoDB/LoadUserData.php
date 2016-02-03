<?php

//src/AppBundle/DataFixtures/MongoDB/LoadUserData.php

namespace AppBundle\DataFixtures\MongoDB;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\ODM\MongoDB\DocumentManager;
use AppBundle\Document\User;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadUserData implements ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(DocumentManager $manager)
    {
        $userAdmin = new User();
        $userAdmin->setUsername('admin');
        $userAdmin->setSalt(md5(uniqid()));
        $plainPassword = 'password123';
        $encoder = $this->container->get('security.password_encoder');
        $password = $encoder->encodePassword($userAdmin, $plainPassword);
        $userAdmin->setPassword($password);
        $userAdmin->setRoles(array("ROLE_ADMIN"));

        $manager->persist($userAdmin);
        $manager->flush();
    }

} 