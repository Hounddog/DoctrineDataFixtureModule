<?php
namespace DoctrineDataFixtureTest\TestAsset\Fixtures;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;

class FixtureA implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
    }
}
