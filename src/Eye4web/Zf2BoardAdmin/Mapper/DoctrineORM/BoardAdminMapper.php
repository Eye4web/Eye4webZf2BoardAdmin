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
use Eye4web\Zf2Board\Entity\BoardInterface;
use Eye4web\Zf2Board\Mapper\DoctrineORM\BoardMapper;
use Eye4web\Zf2BoardAdmin\Mapper\BoardAdminMapperInterface;
use Eye4web\Zf2BoardAdmin\Options\ModuleOptionsInterface;

class BoardAdminMapper extends BoardMapper implements BoardAdminMapperInterface
{
    /** @var EntityManager */
    protected $objectManager;

    /** @var ModuleOptionsInterface */
    protected $options;

    public function __construct(
        ObjectManager $objectManager,
        ModuleOptionsInterface $options
    ) {
        $this->objectManager = $objectManager;
        $this->options = $options;
    }

    /**
     * @param $id
     * @return bool
     * @throws \Exception
     */
    public function delete($id)
    {
        $board = $this->find($id);

        if (!$board) {
            throw new \Exception('The board does not exist');
        }

        $this->objectManager->remove($board);
        $this->objectManager->flush();

        return true;
    }

    /**
     * @param BoardInterface $board
     * @return bool|BoardInterface
     */
    public function create(BoardInterface $board)
    {
        return $this->save($board);
    }

    /**
     * @param BoardInterface $form
     * @return bool|BoardInterface
     */
    public function edit(BoardInterface $board)
    {
        return $this->save($board);
    }
}
