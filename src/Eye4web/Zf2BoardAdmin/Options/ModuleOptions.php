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

namespace Eye4web\Zf2BoardAdmin\Options;

use Zend\Authentication\AuthenticationService;
use Zend\ServiceManager\ServiceManager;
use Zend\Stdlib\AbstractOptions;

class ModuleOptions extends AbstractOptions implements ModuleOptionsInterface
{
    /** @var string */
    protected $boardAdminMapper = 'Eye4web\Zf2BoardAdmin\Mapper\DoctrineORM\BoardAdminMapper';

    /** @var string */
    protected $topicAdminMapper = 'Eye4web\Zf2BoardAdmin\Mapper\DoctrineORM\TopicAdminMapper';

    /** @var string */
    protected $postAdminMapper = 'Eye4web\Zf2BoardAdmin\Mapper\DoctrineORM\PostAdminMapper';


    /**
     * @return string
     */
    public function getBoardAdminMapper()
    {
        return $this->boardAdminMapper;
    }

    /**
     * @param string $boardAdminMapper
     */
    public function setBoardAdminMapper($boardAdminMapper)
    {
        $this->boardAdminMapper = $boardAdminMapper;
    }

    /**
     * @return string
     */
    public function getPostAdminMapper()
    {
        return $this->postAdminMapper;
    }

    /**
     * @param string $postAdminMapper
     */
    public function setPostAdminMapper($postAdminMapper)
    {
        $this->postAdminMapper = $postAdminMapper;
    }

    /**
     * @return string
     */
    public function getTopicAdminMapper()
    {
        return $this->topicAdminMapper;
    }

    /**
     * @param string $topicAdminMapper
     */
    public function setTopicAdminMapper($topicAdminMapper)
    {
        $this->topicAdminMapper = $topicAdminMapper;
    }



}
