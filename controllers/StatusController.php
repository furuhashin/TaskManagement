<?php

class StatusController extends Controller//Controllerクラスのインスタンス先※Controllerクラスはabstrastクラスなので必ずインスタンス化される
{
    protected $auth_actions = array('index', 'post');

    public function indexAction()
    {
        $user = $this->session->get('user');
        $statuses = $this->db_manager->get('Status')->fetchAllTaskName($user['user_id']);//StatusRepositoryクラスのインスタンスを取得し、同クラスのメソッドの実行

      return $this->render(array(//viewファイルで使用する変数を定義
            'statuses' => $statuses,
            'body' => '',
            '_token' => $this->generateCsrfToken('status/post'),
        ));
    }

    public function insert_rendAction()//新規投稿画面のレンダリング
    {
        $status_name = array("未処理","仕掛中","完了");
        $task_name = $this->request->getPost('task_name');
        $status_id = $this->getstatusidAction();
        $deadline = $this->request->getPost('deadline');


        return $this->render(array(
            'status_name' => $status_name,
            'task_name' => $task_name,
            'status_id' => $status_id,
            'deadline' => $deadline,
            '_token' => $this->generateCsrfToken('status/insert'),
        ),'insert');
    }


    public function previewAction()//新規投稿画面のレンダリング
    {

        $task_name = $this->request->getPost('task_name');
        $status_id = $this->request->getPost('status_id');
        $deadline = $this->request->getPost('deadline');


        return $this->render(array(
            'task_name' => $task_name,
            'status_id' => $status_id,
            'deadline' => $deadline,
            '_token' => $this->generateCsrfToken('status/insert'),
        ),'preview');
    }

    public function getstatusidAction()
    {
        $row = $this->db_manager->get('Status')->fetchStatusId();
        $status_id = array_column($row, 'status_name');

        return $status_id;

    }

    public function insertAction()
    {
        if (!$this->request->isPost()) {
            $this->forward404();
        }

        $token = $this->request->getPost('_token');
        if (!$this->checkCsrfToken('status/post', $token)) {
            return $this->redirect('/');
        }

        $task_name = $this->request->getPost('task_name');
        $status_id = $this->request->getPost('status_id');
        $deadline = $this->request->getPost('deadline');

        $errors = array();

        if (!strlen($task_name)) {
            $errors[] = 'ひとことを入力してください。';
        } elseif (mb_strlen($task_name) > 200) {
            $errors[] = 'ひとことは200文字以内で入力してください。';
        }

        if (count($errors) === 0) {
            $user = $this->session->get('user');
            $this->db_manager->get('Status')->insert($task_name,$user['id'],$status_id,$deadline);

            return $this->redirect('/');
        }

        $user = $this->session->get('user');
        $statuses = $this->db_manager->get('Status')->fetchAllTaskName($user['user_id']);

        return $this->render(array(//viewファイルで使用する変数を定義
            'errors' => $errors,
            'task_name' => $task_name,
            'status_id' => $status_id,
            'deadline' => $deadline,
            '_token' => $this->generateCsrfToken('status/post'),
        ), 'index');
    }

    public function userAction($params)
    {
        $user = $this->db_manager->get('User')->fetchByUserName($params['user_name']);
        if (!$user) {
            $this->forward404();
        }

        $statuses = $this->db_manager->get('Status')->fetchAllByUserId($user['id']);

        $following = null;
        if ($this->session->isAuthenticated()){
            $my = $this->session->get('user');
            if ($my['id'] !== $user['id']){
                $following = $this->db_manager->get('Following')->isFollowing($my['id'],$user['id']);//$followingには'true'or'false'が入る
            }
        }

        return $this->render(array(//viewファイルで使用する変数を定義
            'user' => $user,
            'statuses' => $statuses,
            'following' => $following,
            '_token' => $this->generateCsrfToken('account/follow'),
        ));

    }

    public function showAction($params)
    {
        $status = $this->db_manager->get('Status')->fetchByIdAndUserName($params['id'],$params['user_name']);

        if (!$status) {
            $this->forward404();
        }

        return $this->render(array('status' => $status));//viewファイルで使用する変数を定義
    }
}