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

namespace DoctrineDataFixtureModule\Command;

use Symfony\Component\Console\Command\Command,
    Symfony\Component\Console\Input\InputInterface,
    Symfony\Component\Console\Output\OutputInterface,
    Symfony\Component\Console\Input\InputArgument,
    Symfony\Component\Console\Input\InputOption,
    Doctrine\ORM\Tools\SchemaTool,
    Doctrine\DBAL\Migrations\Configuration\Configuration;

use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;

use Zend\ServiceManager\ServiceManager;
/**
 * Command for generate migration classes by comparing your current database schema
 * to your mapping information.
 *
 * @license http://www.opensource.org/licenses/lgpl-license.php LGPL
 * @link    www.doctrine-project.org
 * @since   2.0
 * @author  Jonathan Wage <jonwage@gmail.com>
 */
class ImportCommand extends Command
{
    /**
     * @var array
     */
    private $_paths;

    /**
     * @var ServiceManager
     */
    private $_sm;

    const PURGE_MODE_TRUNCATE = 2;

    protected function configure()
    {
        parent::configure();

        $this->setName('data-fixture:import')
            ->setDescription('Import Data Fixtures')
            ->setHelp(<<<EOT
The import command Imports data-fixtures
EOT
            )
            ->addOption('append', null, InputOption::VALUE_NONE, 'Append data to existing data.')
            ->addOption('purge-with-truncate', null, InputOption::VALUE_NONE, 'Truncate tables before inserting data')
            ->addOption('em', null, InputOption::VALUE_NONE, 'Specifies the EntitiesManager');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $loader = new Loader();
        $purger = new ORMPurger();

        if($input->getOption('em')) {
            $em = $this->_sm->get('doctrine.entitymanager.' . $input->getOption('em'));
        } else {
            $em = $this->_sm->get('doctrine.entitymanager.orm_default');
        }

        if($input->getOption('purge-with-truncate')) {
            $purger->setPurgeMode(self::PURGE_MODE_TRUNCATE);
        }

        $executor = new ORMExecutor($em, $purger);

        foreach($this->_paths as $key => $value) {
            $loader->loadFromDirectory($value);
        }
        $executor->execute($loader->getFixtures(), $input->getOption('append'));
    }

    /**
     * @param array $paths
     */
    public function setPath($paths) 
    {
        $this->_paths = $paths;
    }

    /**
     * @param ServiceManager $sm
     */
    public function setSm(ServiceManager $sm)
    {
        $this->_sm = $sm;
    }
}
