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

namespace Eye4web\Zf2BoardAdmin\Mapper\DoctrineORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManager;
use Eye4web\Zf2Board\Entity\Topic;
use Eye4web\Zf2Board\Service\TopicService;
use Eye4web\Zf2BoardAdmin\Mapper\TopicAdminMapperInterface;

class TopicAdminMapper implements TopicAdminMapperInterface
{
    /** @var EntityManager */
    protected $objectManager;

    /** @var TopicService */
    protected $topicService;

    /**
     * TopicAdminMapper constructor.
     * @param \Doctrine\Persistence\ObjectManager $objectManager
     * @param TopicService $topicService
     */
    public function __construct(
        \Doctrine\Persistence\ObjectManager $objectManager,
        TopicService $topicService
    ) {
        $this->objectManager = $objectManager;
        $this->topicService = $topicService;
    }

    /**
     * @param $id
     * @return bool
     * @throws \Exception
     */
    public function delete($id)
    {
        $topic = $this->topicService->find($id);

        if (!$topic) {
            throw new \Exception('The topic does not exist');
        }

        $this->objectManager->remove($topic);
        $this->objectManager->flush();

        return true;
    }

    /**
     * @param $data
     * @param Topic $topic
     */
    public function edit(Topic $topic)
    {
        $this->objectManager->persist($topic);
        $this->objectManager->flush();
    }

    /**
     * @param $topicId
     * @return bool
     * @throws \Exception
     */
    public function lock($topicId)
    {
        $topic = $this->topicService->find($topicId);

        if (!$topic) {
            throw new \Exception('The topic does not exist');
        }

        $topic->setLocked(true);
        $this->objectManager->flush();

        return true;
    }

    /**
     * @param $topicId
     * @return bool
     * @throws \Exception
     */
    public function unlock($topicId)
    {
        $topic = $this->topicService->find($topicId);

        if (!$topic) {
            throw new \Exception('The topic does not exist');
        }

        $topic->setLocked(false);
        $this->objectManager->flush();

        return true;
    }

    /**
     * @param $topicId
     * @return bool
     * @throws \Exception
     */
    public function pin($topicId)
    {
        $topic = $this->topicService->find($topicId);

        if (!$topic) {
            throw new \Exception('The topic does not exist');
        }

        $topic->setPinned(true);
        $this->objectManager->flush();

        return true;
    }

    /**
     * @param $topicId
     * @return bool
     * @throws \Exception
     */
    public function unpin($topicId)
    {
        $topic = $this->topicService->find($topicId);

        if (!$topic) {
            throw new \Exception('The topic does not exist');
        }

        $topic->setPinned(false);
        $this->objectManager->flush();

        return true;
    }
}
