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
use Eye4web\Zf2BoardAdmin\Exception;
use Eye4web\Zf2BoardAdmin\Form\Board\EditForm as BoardEditForm;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class BoardAdminController extends AbstractActionController
{
    /** @var BoardService */
    protected $boardService;

    /** @var BoardEditForm */
    protected $boardEditForm;

    public function __construct(BoardService $boardService, BoardEditForm $boardEditForm)
    {
        $this->boardService = $boardService;
        $this->boardEditForm = $boardEditForm;
    }

    public function boardListAction()
    {
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
}
