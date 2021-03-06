<?php

class MiniBlogApplication extends Application
{
	protected $login_action = array('account', 'signin');

	public function getRootDir()
	{
		return dirname(__FILE__);//このファイルが格納されているパスを取得
	}

	protected function registerRoutes()
	{
		return array(
			//StatusControllerの他のルーティング
			'/'
			=> array('controller' => 'status', 'action' => 'index'),
			'/status/post'
			=> array('controller' => 'status', 'action' => 'post'),
			'/user/:user_name'
			=> array('controller' => 'status', 'action' => 'user'),
			'/user/:user_name/status/:id'
			=> array('controller' => 'status', 'action' => 'show'),
			'/status/:action'
			=> array('controller' => 'status'),
			'/status/:action/:id'
			=> array('controller' => 'status'),


			//AcountControllerのルーティング
			'/account'
			=> array('controller' => 'account', 'action' => 'index'),
			'/account/:action'
			=> array('controller' => 'account'),
			'/follow'
			=> array('controller' => 'account', 'action' => 'follow'),

			);
	}

	protected function configure()//dbに接続するための情報
	{
		$this->db_manager->connect('master', array(
			'dsn' => 'mysql:dbname=TaskManagementt;host=localhost',
			'user' => 'root',
			'password' => 'password',
			));
	}
}