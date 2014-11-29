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

namespace Eye4web\Zf2BoardAdmin\Controller;

use Eye4web\Zf2Board\Service\BoardService;
use Eye4web\Zf2Board\Service\TopicService;
use Eye4web\Zf2BoardAdmin\Service\TopicAdminService;
use Eye4web\Zf2BoardAdmin\Exception;
use Eye4web\Zf2BoardAdmin\Form\Topic\EditForm as TopicEditForm;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class TopicAdminController extends AbstractActionController
{
    /** @var BoardService */
    protected $boardService;

    /** @var TopicService */
    protected $topicService;

    /** @var TopicAdminService */
    protected $topicAdminService;

    /** @var TopicEditForm */
    protected $topicEditForm;

    public function __construct(BoardService $boardService,
                                TopicService $topicService,
                                TopicAdminService $topicAdminService,
                                TopicEditForm $topicEditForm)
    {
        $this->boardService = $boardService;
        $this->topicService = $topicService;
        $this->topicAdminService = $topicAdminService;
        $this->topicEditForm = $topicEditForm;
    }

    public function topicDeleteAction()
    {
        $topic = $this->topicService->find($this->params("id"));
        $boardId = $topic->getid();

        if ($topic) {
            $this->topicAdminService->delete($this->params("id"));
        }

        return $this->redirect()->toRoute('zfcadmin/zf2-board-admin/topic/list', ['board' => $boardId]);
    }

    public function topicListAction()
    {
        $boardService = $this->boardService;
        $topicService = $this->topicService;

        $board = $boardService->find($this->params('board'));

        if (!$board) {
            return $this->redirect()->toRoute('zfcadmin/zf2-board-admin/board/list');
        }

        $topics = $topicService->findByBoard($board->getId());

        $viewModel = new ViewModel([
            'board' => $board,
            'topics' => $topics,
        ]);

        $viewModel->setTemplate('eye4web-zf2-board-admin/topic/list.phtml');

        return $viewModel;
    }

    public function topicEditAction()
    {
        $topicService = $this->topicService;
        $boardService = $this->boardService;
        $id = $this->params('id');

        $topic = $topicService->find($id);

        if (!$topic) {
            throw new Exception\RuntimeException('Topic with ID #' . $id . ' could not be found');
        }

        $board = $boardService->find($topic->getBoard());

        $form = $this->topicEditForm;
        $form->bind($topic);

        $viewModel = new ViewModel([
            'form' => $form,
            'topic' => $topic,
        ]);

        $viewModel->setTemplate('eye4web-zf2-board-admin/topic/edit.phtml');

        $redirectUrl = $this->url()->fromRoute('zfcadmin/zf2-board-admin/topic/edit', ['id' => $topic->getId()]);

        $prg = $this->prg($redirectUrl, true);

        if ($prg instanceof \Zend\Http\PhpEnvironment\Response) {
            return $prg;
        } elseif ($prg === false) {
            return $viewModel;
        }

        if ($topicService->edit($prg, $topic)) {
            return $this->redirect()->toRoute('zfcadmin/zf2-board-admin/topic/list', ['board' => $board->getId()]);
        }

        return $viewModel;
    }

}
