<?php

class StatusController extends Controller
{
    protected $auth_actions = array('index', 'post');

    public function indexAction()
    {
        $sql = "SELECT id, task_name, status_name, deadline FROM tasks LEFT JOIN status ON tasks.status_id=status.status_id";
        $statuses = $this->pager_search($sql);

        return $this->render(array(//viewファイルで使用する変数を定義
            'statuses' => $statuses,
            'body' => '',
            '_token' => $this->generateCsrfToken('status'),
        ));
    }

    public function getstatusidAction()
    {
        $row = $this->db_manager->get('Status')->fetchStatusId();
        $status_name = array_column($row, 'status_name');

        return $status_name;
    }

    public function insert_rendAction()//新規投稿画面のレンダリング
    {
        $task_name = $this->request->getPost('task_name');

        $deadline = $this->request->getPost('deadline');


        return $this->render(array(
            'task_name' => $task_name,
            'deadline' => $deadline,
            '_token' => $this->generateCsrfToken('status/insert'),
        ),'insert');
    }

    public function edit_rendAction($params)//編集確認画面のレンダリング
    {
        $statuses = $this->db_manager->get('Status')->fetchTaskById($params['id']);

        return $this->render(array(
            'statuses' => $statuses,
            '_token' => $this->generateCsrfToken('status/edit_rend'),
        ),'edit_rend');
    }

    public function delete_previewAction($params)//削除の確認画面のレンダリング
    {
        $statuses = $this->db_manager->get('Status')->fetchTaskById($params['id']);

        return $this->render(array(
            'statuses' => $statuses,
            '_token' => $this->generateCsrfToken('status/delete_preview'),
        ),'delete_preview');
    }


    public function insert_previewAction()//新規追加プレビュー画面のレンダリング
    {
        $errors = array();
        $task_name = $this->request->getPost('task_name');
        $status_name = $this->request->getPost('status_name');
        $deadline = $this->request->getPost('deadline');

        if (!strlen($task_name)) {
            $errors[] = 'タスク名を入力してください。';
        } elseif (mb_strlen($task_name) > 100) {
            $errors[] = 'タスク名は100文字以内で入力してください。';
        }

        if (count($errors) === 0) {
            return $this->render(array(
                'task_name' => $task_name,
                'status_name' => $status_name,
                'deadline' => $deadline,
                '_token' => $this->generateCsrfToken('status/insert'),
            ),'insert_preview');
        }
        return $this->render(array(
            'errors' => $errors,
            'task_name' => $task_name,
            'status_name' => $status_name,
            'deadline' => $deadline,
            '_token' => $this->generateCsrfToken('status/insert'),
            ), 'insert');

    }

    public function edit_previewAction($params)//プレビュー画面のレンダリング
    {
        $errors = array();
        $task_name = $this->request->getPost('task_name');
        $status_name = $this->request->getPost('status_name');
        $deadline = $this->request->getPost('deadline');
        $id = $this->request->getPost('id');
        $statuses = $this->db_manager->get('Status')->fetchTaskById($params['id']);

        if (!strlen($task_name)) {
            $errors[] = 'タスク名を入力してください。';
        } elseif (mb_strlen($task_name) > 100) {
            $errors[] = 'タスク名は100文字以内で入力してください。';
        }

        if (count($errors) === 0) {
            return $this->render(array(
                'id' => $id,
                'task_name' => $task_name,
                'status_name' => $status_name,
                'deadline' => $deadline,
                '_token' => $this->generateCsrfToken('status/edit_preview'),
            ),'edit_preview');
        }
        return $this->render(array(
            'statuses' => $statuses,
            'errors' => $errors,
            'task_name' => $task_name,
            'status_name' => $status_name,
            'deadline' => $deadline,
            '_token' => $this->generateCsrfToken('status'),
        ), 'edit_rend');

    }


    public function insertAction()
    {
        if (!$this->request->isPost()) {
            $this->forward404();
        }

        $token = $this->request->getPost('_token');
        if (!$this->checkCsrfToken('status/insert', $token)) {
            return $this->redirect('/');
        }

        $task_name = $this->request->getPost('task_name');
        $status_name = $this->request->getPost('status_name');
        $status_id = $this->request->getPost('status_id');
        $deadline = $this->request->getPost('deadline');

        $errors = array();
        if (!strlen($task_name)) {
            $errors[] = 'タスク名を入力してください。';
        } elseif (mb_strlen($task_name) > 200) {
            $errors[] = 'タスク名は100文字以内で入力してください。';
        }

        if (count($errors) === 0) {
            $user = $this->session->get('user');
            $this->db_manager->get('Status')->insert($task_name,$user['user_id'],$status_id,$deadline);

            return $this->render(array(//viewファイルで使用する変数を定義
                'errors' => $errors,
                'task_name' => $task_name,
                'status_name' => $status_name,
                'deadline' => $deadline,
                '_token' => $this->generateCsrfToken('status/insert'),
            ), 'finish');
        }

    }

    public function deleteAction($params)
    {
        $token = $this->request->getPost('_token');
        if (!$this->checkCsrfToken('status/delete_preview', $token)) {
            return $this->redirect('/');
        }

        $task_name = $this->request->getPost('task_name');
        $status_name = $this->request->getPost('status_name');
        $deadline = $this->request->getPost('deadline');

        $this->db_manager->get('Status')->delete($params['id']);


        return $this->render(array(//viewファイルで使用する変数を定義
            'task_name' => $task_name,
            'status_name' => $status_name,
            'deadline' => $deadline,
            '_token' => $this->generateCsrfToken('status/delete'),
        ), 'delete_finish');

    }


    public function editAction()
    {
        if (!$this->request->isPost()) {
            $this->forward404();
        }

        $token = $this->request->getPost('_token');
        if (!$this->checkCsrfToken('status/edit_preview', $token)) {
            return $this->redirect('/');
        }

        $task_name = $this->request->getPost('task_name');
        $status_name = $this->request->getPost('status_name');
        $status_id = $this->request->getPost('status_id');
        $deadline = $this->request->getPost('deadline');
        $id = $this->request->getPost('id');

        $errors = array();
        if (!strlen($task_name)) {
            $errors[] = 'タスク名を入力してください。';
        } elseif (mb_strlen($task_name) > 200) {
            $errors[] = 'タスク名は100文字以内で入力してください。';
        }

        if (count($errors) === 0) {
            $this->db_manager->get('Status')->edit($task_name,$status_id,$deadline,$id);

            return $this->render(array(//viewファイルで使用する変数を定義
                'id' => $id,
                'errors' => $errors,
                'task_name' => $task_name,
                'status_name' => $status_name,
                'deadline' => $deadline,
                '_token' => $this->generateCsrfToken('status/edit'),
            ), 'finish');
        }

    }

}