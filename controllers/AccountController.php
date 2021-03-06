<?php

class AccountController extends Controller
{
	protected $auth_actions = array('index', 'signout','follow');
	public function signupAction()
	{
		return $this->render(array(
			'user_name' => '',
			'password' => '',
			'_token' => $this->generateCsrfToken('account/signup'),
			));
	}


	public function registerAction()
	{
		if (!$this->request->isPost()){
			$this->forward404();
		}

		$token = $this->request->getPost('_token');
		if (!$this->checkCsrfToken('account/signup',$token)){
			return $this->redirect('/account/signup');
		}

		$user_name = $this->request->getPost('user_name');
		$password = $this->request->getPost('password');

		$errors = array();

		if (!strlen($user_name)){
			$errors[] = 'ユーザIDを入力してください';
		} elseif(!preg_match('/^\w{3,20}$/', $user_name)) {
			$errors[] = 'ユーザIDは半角英数字及びアンダースコアを3~20文字以内で入力してください';
		} elseif (!$this->db_manager->get('User')->isUniqueUserName($user_name)){
			$errors[] = 'ユーザIDは既に使用されています';
		}

		if (!strlen($password)) {
			$errors[] = 'パスワードを入力してください';
		}elseif(4>strlen($password) || strlen($password)>30){
			$errors[] = 'パスワードは30文字以内で入力してください';
		}

		if (count($errors) === 0){
			$this->db_manager->get('User')->insert($user_name,$password);

		$this->session->setAuthenticated(true);

		$user = $this->db_manager->get('User')->fetchByUserName($user_name);//userテーブルから情報を取得
		$this->session->set('user', $user);//取得した情報をセッション変数に格納

		return $this->redirect('/');
		}

		return $this->render(array(
			'user_name' => $user_name,
			'password' => $password,
			'errors' => $errors,
			'_token' => $this->generateCsrfToken('account/signup'),
		),'signup');
	}

	public function indexAction()
	{
		$user = $this->session->get('user');

		return $this->render(array(
			'user' => $user,
			));
	}

	public function signinAction()
	{
		if ($this->session->isAuthenticated()) {
			return $this->redirect('/account');
		}
			return $this->render(array(
				'user_name' => '',
				'password' => '',
				'_token' => $this->generateCsrfToken('account/signin'),
			));

	}

	public function authenticateAction()
	{
		if ($this->session->isAuthenticated()) {
			return $this->redirect('/account');
		}

		if (!$this->request->isPost()) {
			$this->forward404();
		}

		$token = $this->request->getPost('_token');
		if (!$this->checkCsrfToken('account/signin', $token)){
			return $this->redirect('/account/signin');
		}

		$user_name = $this->request->getPost('user_name');
		$password = $this->request->getPost('password');

		$errors = array();

		if (!strlen($user_name)){
			$errors[] = 'ユーザIDを入力してください。';
		}

		if (!strlen($password)){
			$errors[] = 'パスワードを入力してください';
		}

		if (count($errors) === 0){
			$user_repository = $this->db_manager->get('User');
			$user = $user_repository->fetchByUserName($user_name);

			if (!$user || ($user['password'] !== $user_repository->Password($password))){
				$errors[] = 'ユーザIDかパスワードが不正です';
			} else {
				$this->session->setAuthenticated(true);
				$this->session->set('user',$user);//ここで対象のユーザ情報一行をセッション変数に格納している。

				return $this->redirect('/');
			}
		}

		return $this->render(array(
			'user_name' => $user_name,
			'password' => $password,
			'errors' => $errors,
			'_token' => $this->generateCsrfToken('account/signin'),
		), 'signin');
	}

	public function signoutAction()
	{
		$this->session->clear();
		$this->session->setAuthenticated(false);

		return $this->redirect('/account/signin');
	}


}
