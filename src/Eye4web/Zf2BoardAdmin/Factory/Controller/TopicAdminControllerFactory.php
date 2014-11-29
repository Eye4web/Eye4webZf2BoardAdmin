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

namespace Eye4web\Zf2BoardAdmin\Factory\Controller;

use Eye4web\Zf2BoardAdmin\Controller\TopicAdminController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class TopicAdminControllerFactory implements FactoryInterface
{
    /**
     * Create controller
     *
     * @param ServiceLocatorInterface $controllerManager
     * @return BoardAdminController
     */
    public function createService(ServiceLocatorInterface $controllerManager)
    {
        /** @var ServiceLocatorInterface $serviceLocator */
        $serviceLocator = $controllerManager->getServiceLocator();

        /** @var \Eye4web\Zf2Board\Service\BoardService $boardService */
        $boardService = $serviceLocator->get('Eye4web\Zf2Board\Service\BoardService');

        /** @var \Eye4web\Zf2Board\Service\TopicService $topicService */
        $topicService = $serviceLocator->get('Eye4web\Zf2Board\Service\TopicService');

        /** @var \Eye4web\Zf2BoardAdmin\Service\TopicAdminService $topicAdminService */
        $topicAdminService = $serviceLocator->get('Eye4web\Zf2BoardAdmin\Service\TopicAdminService');

        /** @var \Eye4web\Zf2BoardAdmin\Form\Topic\EditForm $topicEditForm */
        $topicEditForm = $serviceLocator->get('Eye4web\Zf2BoardAdmin\Form\Topic\EditForm');

        $controller = new TopicAdminController($boardService, $topicService, $topicAdminService, $topicEditForm);

        return $controller;
    }
}
