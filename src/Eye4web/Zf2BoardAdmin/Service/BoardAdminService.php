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

use Eye4web\Zf2Board\Entity\BoardInterface;
use Eye4web\Zf2BoardAdmin\Mapper\BoardAdminMapperInterface;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerAwareTrait;
use Zend\Form\FormInterface;

class BoardAdminService implements BoardAdminServiceInterface, EventManagerAwareInterface
{
    use EventManagerAwareTrait;

    /** @var FormInterface */
    protected $boardCreateForm;

    protected $boardAdminMapper;

    protected $slugService;

    public function __construct(BoardAdminMapperInterface $boardAdminMapper, $boardCreateForm, $boardEditForm, $slugService)
    {
        $this->boardCreateForm = $boardCreateForm;
        $this->boardEditForm = $boardEditForm;
        $this->boardAdminMapper = $boardAdminMapper;
        $this->slugService = $slugService;
    }

    function delete($id)
    {
        $this->getEventManager()->trigger('board.delete', $this, [
            'id' => $id
        ]);

        $this->boardAdminMapper->delete($id);
    }

    /**
     * @param array $data
     * @return bool|BoardInterface
     */
    public function create(array $data)
    {
        $form = $this->boardCreateForm;
        $form->setData($data);

        if (!$form->isValid()) {
            return false;
        }

        /** @var BoardInterface $board */
        $board = $form->getData();

        if ($form->get('autogenerate_slug')->getValue() === 'true') {
            $slug = $this->slugService->slugify($board->getName());
            $board->setSlug($slug);
        }

        $this->getEventManager()->trigger('board.create.pre', $this, [
            'board' => $board
        ]);

        $board = $this->boardAdminMapper->create($board);

        $this->getEventManager()->trigger('board.create', $this, [
            'board' => $board
        ]);

        return $board;
    }

    /**
     * @param array $data
     * @param BoardInterface $board
     * @return bool|BoardInterface
     */
    public function edit(array $data, BoardInterface $board)
    {
        $form = $this->boardEditForm;
        $form->bind($board);

        $form->setData($data);

        if (!$form->isValid()) {
            return false;
        }

        /** @var BoardInterface $board */
        $board = $form->getData();

        $this->getEventManager()->trigger('board.edit.pre', $this, [
            'board' => $board
        ]);

        $board = $this->boardAdminMapper->edit($board);

        $this->getEventManager()->trigger('board.edit', $this, [
            'board' => $board
        ]);

        return $board;
    }
}
