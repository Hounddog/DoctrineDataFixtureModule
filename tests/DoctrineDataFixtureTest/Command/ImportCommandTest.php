<?php
/*
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the LGPL. For more information, see
 * <http://www.doctrine-project.org>.
 */
namespace DoctrineDataFixtureTest\Command;


use DoctrineDataFixtureModule\Command\ImportCommand;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Console\Tester\CommandTester;

use Zend\ServiceManager\ServiceManager;
use Zend\Mvc\Service\ServiceManagerConfig;
use PHPUnit_Framework_TestCase;
use Doctrine\ORM\Tools\Setup;

/**
 * Test Import commands for fixtures
 *
 * @license http://www.opensource.org/licenses/lgpl-license.php LGPL
 * @link    www.doctrine-project.org
 * @author  Martin Shwalbe <martin.shwalbe@gmail.com>
 */
class ImportCommandTest extends PHPUnit_Framework_TestCase
{
   /**
     * @dataProvider provider
     */
    public function testExecute($option, $value, $assert)
    {
        $serviceLocator = new ServiceManager(new ServiceManagerConfig());

        $command = new ImportCommand($serviceLocator);

        $command->setentityManager($this->getMockSqliteEntityManager());
        $command->setPurger($this->getMockPurger());
        $paths = array(
            'DoctrineDataFixture_Test_Paths' => __DIR__ . '/../TestAsset/Fixtures/NoSL',
        );
        $command->setPath($paths);

        $commandTester = new CommandTester($command);
        $commandTester->execute(
            array(
                $option=> $value,
            )
        );

        $loader= $command->getLoader();        
        $fixtures = $loader->getFixtures();

        $this->assertArrayHasKey($assert, $fixtures);
    }

    public function provider() {
        return array(
            array('--append', true, 'DoctrineDataFixtureTest\TestAsset\Fixtures\NoSL\FixtureA'),
            array('--fixtures', __DIR__ . '/../TestAsset/Fixtures/NoSL', 'DoctrineDataFixtureTest\TestAsset\Fixtures\NoSL\FixtureA'),
            array('--fixtures', __DIR__ . '/../TestAsset/Fixtures/HasSL/FixtureA.php', 'DoctrineDataFixtureTest\TestAsset\Fixtures\HasSL\FixtureA')
        );
    }

    private function getMockFixture($em)
    {
        return $this->getMock('Doctrine\Common\DataFixtures\FixtureInterface');
    }

    private function getMockPurger()
    {
        return $this->getMock('Doctrine\Common\DataFixtures\Purger\ORMPurger');
    }

    /**
     * EntityManager mock object together with
     * annotation mapping driver and pdo_sqlite
     * database in memory
     *
     * @return EntityManager
     */
    protected function getMockSqliteEntityManager()
    {
        $dbParams = array('driver' => 'pdo_sqlite', 'memory' => true);
        $config = Setup::createAnnotationMetadataConfiguration(array(__DIR__ . '/../TestAsset/Entity'), true);
        return EntityManager::create($dbParams, $config);
    }

    protected function getMockEntityManager()
    {
        $driver = $this->getMock('Doctrine\DBAL\Driver');
        $driver->expects($this->once())
            ->method('getDatabasePlatform')
            ->will($this->returnValue($this->getMock('Doctrine\DBAL\Platforms\MySqlPlatform')));

        $conn = $this->getMock('Doctrine\DBAL\Connection', array(), array(array(), $driver));
        $conn->expects($this->once())
            ->method('getEventManager')
            ->will($this->returnValue($this->getMock('Doctrine\Common\EventManager')));

        $config = $this->getMock('Doctrine\ORM\Configuration');
        $config->expects($this->once())
            ->method('getProxyDir')
            ->will($this->returnValue('test'));

        $config->expects($this->once())
            ->method('getProxyNamespace')
            ->will($this->returnValue('Proxies'));

        $config->expects($this->once())
            ->method('getMetadataDriverImpl')
            ->will($this->returnValue($this->getMock('Doctrine\ORM\Mapping\Driver\DriverChain')));

        $em = EntityManager::create($conn, $config);
        return $em;
    }
}
