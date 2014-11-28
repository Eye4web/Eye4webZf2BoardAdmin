<?php

/**
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
 * and is licensed under the MIT license.
 */

namespace Eye4web\Zf2BoardAdmin\Factory\Service;

use Eye4web\Zf2BoardAdmin\Service\BoardAdminService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class BoardAdminServiceFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return BoardAdminService
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var \Eye4web\Zf2BoardAdmin\Options\ModuleOptions $options */
        $options = $serviceLocator->get('Eye4web\Zf2BoardAdmin\Options\ModuleOptions');

        /** @var \Eye4web\Zf2BoardAdmin\Mapper\BoardAdminMapperInterface $mapper */
        $mapper = $serviceLocator->get($options->getBoardAdminMapper());

        $boardCreateForm = $serviceLocator->get('Eye4web\Zf2BoardAdmin\Form\Board\CreateForm');

        $boardEditForm = $serviceLocator->get('Eye4web\Zf2BoardAdmin\Form\Board\EditForm');

        $slugService = new \Cocur\Slugify\Slugify;

        $service = new BoardAdminService($mapper, $boardCreateForm, $boardEditForm, $slugService);

        return $service;
    }
}
