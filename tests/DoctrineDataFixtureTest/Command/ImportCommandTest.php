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

use PHPUnit_Framework_TestCase;
use Doctrine\ORM\Tools\Setup;

use Zend\ServiceManager\ServiceManager;
use Zend\Mvc\Service\ServiceManagerConfig;

/**
 * Test Import commands for fixtures
 *
 * @license http://www.opensource.org/licenses/lgpl-license.php LGPL
 * @link    www.doctrine-project.org
 * @author  Martin Shwalbe <martin.shwalbe@gmail.com>
 */
class ImportCommandTest extends PHPUnit_Framework_TestCase
{
    public function testExecutePurgeWithTruncate()
    {
        $paths = array(
            'DoctrineDataFixture_Test_Paths' => __DIR__ . '/../TestAsset/Fixtures/NoSL',
        );

        $command = new ImportCommand(
            $this->getMockServiceLocatorAwareLoader(),
            $this->getMockPurger(),
            $this->getMockSqliteEntityManager(),
            $paths
        );

        $commandTester = new CommandTester($command);
        $commandTester->execute(
            array(
                '--purge-with-truncate' => 'true',
            )
        );
    }

    private function getMockFixture()
    {
        return $this->getMock('Doctrine\Common\DataFixtures\FixtureInterface');
    }

    private function getMockPurger()
    {
        $purger = $this->getMock('Doctrine\Common\DataFixtures\Purger\ORMPurger');

        $purger->expects($this->once())
            ->method('setPurgeMode')
            ->with($this->equalTo(2));
            
        return $purger;
    }

    protected function getMockServiceLocatorAwareLoader()
    {
        $loader = $this->getMock(
            'DoctrineDataFixtureModule\Loader\ServiceLocatorAwareLoader',
            array(),
            array(new ServiceManager(new ServiceManagerConfig()))
        );

        $loader->expects($this->once())
            ->method('getFixtures')
            ->will($this->returnValue(
                array($this->getMockFixture())
            ));

        $loader->expects($this->once())
            ->method('loadPaths');

        return $loader;
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
}
