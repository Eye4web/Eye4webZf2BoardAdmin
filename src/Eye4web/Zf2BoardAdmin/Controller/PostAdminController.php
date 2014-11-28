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

use Eye4web\Zf2Board\Service\AuthorService;
use Eye4web\Zf2Board\Service\BoardService;
use Eye4web\Zf2Board\Service\PostService;
use Eye4web\Zf2Board\Service\TopicService;
use Eye4web\Zf2BoardAdmin\Exception;
use Eye4web\Zf2BoardAdmin\Form\Board\EditForm as BoardEditForm;
use Eye4web\Zf2BoardAdmin\Form\Topic\EditForm as TopicEditForm;
use Eye4web\Zf2Board\Form\Post\EditForm as PostEditForm;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class PostAdminController extends AbstractActionController
{
    /** @var BoardService */
    protected $boardService;

    /** @var TopicService */
    protected $topicService;

    /** @var PostService */
    protected $postService;

    /** @var AuthorService */
    protected $authorService;

    /** @var PostEditForm */
    protected $postEditForm;

    public function __construct(BoardService $boardService,
                                TopicService $topicService,
                                PostService $postService,
                                AuthorService $authorService,
                                PostEditForm $postEditForm)
    {
        $this->boardService = $boardService;
        $this->topicService = $topicService;
        $this->postService = $postService;
        $this->authorService = $authorService;
        $this->postEditForm = $postEditForm;
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

        if ($this->params()->fromQuery('delete', false)) {
            $post = $postService->find($this->params()->fromQuery('delete'));

            if ($post) {
                $postService->delete($this->params()->fromQuery('delete'));
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

    public function postEditAction()
    {
        $postService = $this->postService;
        $topicService = $this->topicService;
        $id = $this->params('id');

        $post = $postService->find($id);

        if (!$post) {
            throw new Exception\RuntimeException('Post with ID #' . $id . ' could not be found');
        }

        $topic = $topicService->find($post->getTopic());

        $form = $this->postEditForm;
        $form->bind($post);

        $viewModel = new ViewModel([
            'form' => $form,
            'post' => $post,
        ]);

        $viewModel->setTemplate('eye4web-zf2-board-admin/post/edit.phtml');

        $redirectUrl = $this->url()->fromRoute('zfcadmin/zf2-board-admin/post/edit', ['id' => $post->getId()]);

        $prg = $this->prg($redirectUrl, true);

        if ($prg instanceof \Zend\Http\PhpEnvironment\Response) {
            return $prg;
        } elseif ($prg === false) {
            return $viewModel;
        }

        $user = $this->authorService->find($post->getUser());

        if ($postService->update($prg, $topic, $user)) {
            return $this->redirect()->toRoute('zfcadmin/zf2-board-admin/post/list', ['topic' => $topic->getId()]);
        }

        return $viewModel;
    }
}
