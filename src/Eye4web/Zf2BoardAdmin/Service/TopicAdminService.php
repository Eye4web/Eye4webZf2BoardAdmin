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

namespace Eye4web\Zf2BoardAdmin\Service;

use Eye4web\Zf2BoardAdmin\Mapper\TopicAdminMapperInterface;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerAwareTrait;

class TopicAdminService implements TopicAdminServiceInterface, EventManagerAwareInterface
{
    use EventManagerAwareTrait;
    
    protected $topicAdminMapper;

    public function __construct(TopicAdminMapperInterface $topicAdminMapper)
    {
        $this->topicAdminMapper = $topicAdminMapper;
    }

    public function edit($topic)
    {
        $this->getEventManager()->trigger('topic.edit', $this, [
            'topic' => $topic
        ]);
        $this->topicAdminMapper->edit($topic);
    }

    function delete($id)
    {
        $this->getEventManager()->trigger('topic.delete', $this, [
            'id' => $id
        ]);

        $this->topicAdminMapper->delete($id);
    }

    function lock($id)
    {
        $this->getEventManager()->trigger('topic.lock', $this, [
            'id' => $id
        ]);

        $this->topicAdminMapper->lock($id);
    }

    function unlock($id)
    {
        $this->getEventManager()->trigger('topic.unlock', $this, [
            'id' => $id
        ]);

        $this->topicAdminMapper->unlock($id);
    }

    function pin($id)
    {
        $this->getEventManager()->trigger('topic.pin', $this, [
            'id' => $id
        ]);

        $this->topicAdminMapper->pin($id);
    }

    function unpin($id)
    {
        $this->getEventManager()->trigger('topic.unpin', $this, [
            'id' => $id
        ]);

        $this->topicAdminMapper->unpin($id);
    }
}
