<?php
namespace DoctrineDataFixtureModuleTest\TestAsset\Fixtures\NoSL;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;

class FixtureA implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
    }
}
