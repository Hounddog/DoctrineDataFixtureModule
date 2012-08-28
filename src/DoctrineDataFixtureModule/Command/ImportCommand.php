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
    protected function configure()
    {
        parent::configure();

        $this
            ->setName('data-fixture:import')
            ->setDescription('Import Data Fixtures')
            ->setHelp(<<<EOT
The <info>%command.name%</info> command generates a migration by comparing your current database to your mapping information:

    <info>%command.full_name%</info>

You can optionally specify a <comment>--editor-cmd</comment> option to open the generated file in your favorite editor:

    <info>%command.full_name% --editor-cmd=mate</info>
EOT
            )
            ->addOption('filter-expression', null, InputOption::VALUE_OPTIONAL, 'Tables which are filtered by Regular Expression.');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        echo 'importing data-fixtures';
        exit;
    }
}
