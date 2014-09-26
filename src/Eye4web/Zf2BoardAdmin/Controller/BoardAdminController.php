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
use Eye4web\Zf2Board\Service\PostService;
use Eye4web\Zf2Board\Service\TopicService;
use Eye4web\Zf2BoardAdmin\Exception;
use Eye4web\Zf2BoardAdmin\Form\Board\EditForm as BoardEditForm;
use Eye4web\Zf2BoardAdmin\Form\Topic\EditForm as TopicEditForm;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class BoardAdminController extends AbstractActionController
{
    /** @var BoardService */
    protected $boardService;

    /** @var TopicService */
    protected $topicService;

    /** @var PostService */
    protected $postService;

    /** @var BoardEditForm */
    protected $boardEditForm;

    /** @var TopicEditForm */
    protected $topicEditForm;

    public function __construct(BoardService $boardService, TopicService $topicService, PostService $postService, BoardEditForm $boardEditForm, TopicEditForm $topicEditForm)
    {
        $this->boardService = $boardService;
        $this->topicService = $topicService;
        $this->postService = $postService;
        $this->boardEditForm = $boardEditForm;
        $this->topicEditForm = $topicEditForm;
    }

    public function boardListAction()
    {
        $boardService = $this->boardService;

        if (isset($_GET['delete'])) {
            $board = $boardService->find($_GET['delete']);

            if ($board) {
                $boardService->delete($_GET['delete']);
            }

            return $this->redirect()->toRoute('zfcadmin/zf2-board-admin/board/list');
        }

        $boards = $this->boardService->findAll();

        $viewModel = new ViewModel([
            'boards' => $boards
        ]);

        $viewModel->setTemplate('eye4web-zf2-board-admin/board/list.phtml');

        return $viewModel;
    }

    public function boardEditAction()
    {
        $boardService = $this->boardService;
        $id = $this->params('id');

        $board = $boardService->find($id);

        if (!$board) {
            throw new Exception\RuntimeException('Board with ID #' . $id . ' could not be found');
        }

        $form = $this->boardEditForm;
        $form->bind($board);

        $viewModel = new ViewModel([
            'form' => $form,
            'board' => $board,
        ]);

        $viewModel->setTemplate('eye4web-zf2-board-admin/board/edit.phtml');

        $redirectUrl = $this->url()->fromRoute('zfcadmin/zf2-board-admin/board/edit', ['id' => $board->getId()]);

        $prg = $this->prg($redirectUrl, true);

        if ($prg instanceof \Zend\Http\PhpEnvironment\Response) {
            return $prg;
        } elseif ($prg === false) {
            return $viewModel;
        }

        if ($boardService->edit($prg, $board)) {
            return $this->redirect()->toRoute('zfcadmin/zf2-board-admin/board/list');
        }

        return $viewModel;
    }

    public function topicListAction()
    {
        $boardService = $this->boardService;
        $topicService = $this->topicService;

        $board = $boardService->find($this->params('board'));

        if (isset($_GET['delete'])) {
            $topic = $topicService->find($_GET['delete']);

            if ($topic) {
                $topicService->delete($_GET['delete']);
            }

            return $this->redirect()->toRoute('zfcadmin/zf2-board-admin/topic/list', ['board' => $board->getId()]);
        }

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
        $board = $boardService->find($topic->getBoard());

        if (!$topic) {
            throw new Exception\RuntimeException('Topic with ID #' . $id . ' could not be found');
        }

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

    public function postListAction()
    {
        $boardService = $this->boardService;
        $topicService = $this->topicService;
        $postService = $this->postService;

        $topic = $topicService->find($this->params('topic'));

        if (!$topic) {
            return $this->redirect()->toRoute('zfcadmin/zf2-board-admin/board/list');
        }

        $board = $boardService->find($topic->getBoard());

        if (isset($_GET['delete'])) {
            $post = $postService->find($_GET['delete']);

            if ($post) {
                $postService->delete($_GET['delete']);
            }

            return $this->redirect()->toRoute('zfcadmin/zf2-board-admin/post/list', ['topic' => $topic->getId()]);
        }

        $posts = $postService->findByTopic($topic->getId());

        $viewModel = new ViewModel([
            'board' => $board,
            'topic' => $topic,
            'posts' => $posts,
        ]);

        $viewModel->setTemplate('eye4web-zf2-board-admin/post/list.phtml');

        return $viewModel;
    }
}
