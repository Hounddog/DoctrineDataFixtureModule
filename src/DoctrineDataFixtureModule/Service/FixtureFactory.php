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
 * and is licensed under the MIT license. For more information, see
 * <http://www.doctrine-project.org>.
 */

namespace DoctrineDataFixtureModule\Service;


use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Factory for Fixtures
 *
 * @license MIT
 * @link    www.doctrine-project.org
 * @author  Martin Shwalbe <martin.shwalbe@gmail.com>
 */
class FixtureFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $sl)
    {
        /** @var $options \DoctrineORMModule\Options\DBALConnection */
        $options = $this->getOptions($sl, 'fixtures');
        
        return $options;
    }

    /**
     * Gets options from configuration based on name.
     *
     * @param  ServiceLocatorInterface      $sl
     * @param  string                       $key
     * @param  null|string                  $name
     * @return \Zend\Stdlib\AbstractOptions
     * @throws \RuntimeException
     */
    public function getOptions(ServiceLocatorInterface $sl, $key)
    {
        $options = $sl->get('config');
        if (!isset($options['doctrine']['fixture'])) {
            return array();
        }
        
        return $options['doctrine']['fixture'];
    }
}
