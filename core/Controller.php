<?php

abstract class Controller
{
	protected $controller_name;
	protected $action_name;
	protected $application;
	protected $request;
	protected $response;
	protected $session;
	protected $db_manager;

	public function __construct($application)
	{
		$this->controller_name = strtolower(substr(get_class($this), 0, -10));

		$this->application = $application;
		$this->request= $application->getRequest();
		$this->response = $application->getResponse();
		$this->session = $application->getSession();
		$this->db_manager = $application->getDbManager();
	}

	public function run($action, $params = array())
	{
		$this->action_name = $action;

		$action_method = $action . 'Action';
		if (!method_exists($this, $action_method)) {
			$this->forward404();
		}

		$content = $this->$action_method($params);//可変関数を用いている。Conrrolleクラスは抽象クラスなので、実態は〜Controllerクラスのインスタンス。
												  //ここの$thisはApplicatonクラスで作られた"$controller_class"クラスのインスタンスex.StatusController

		return $content;
	}

	protected function render($variables = array(), $template = null, $layout = 'layout')//render()は"$controller_class"クラスで行われる.viewクラスのrender()をラッピングしている。

	{
		$defaults = array(
			'request' => $this->request,
			'base_url' => $this->request->getBaseUrl(),
			'session' => $this->session,
			);
		$view = new View($this->application->getViewDir(), $defaults);

		if (is_null($template)) {
			$template = $this->action_name;
		}

		$path = $this->controller_name . '/' .$template;

		return $view->render($path, $variables, $layout);
	}

	protected function forward404()
	{
		throw new HttpNotFoundException('Forwarded  404 page from' . $this->controller_name . '/' . $this->action_name);
	}

	protected function redirect($url)
	{
		if (!preg_match('#https?://#', $url)) {
			$protocol = $this->request->isSsl() ? 'https://' : 'http://';
			$host = $this->request->getHost();
			$base_url = $this->request->getBaseUrl();

			$url = $protocol . $host . $base_url . $url;
		}
		$this->response->setStatusCode(302, 'Found');
		$this->response->setHttpHeader('Location', $url);
	}

	protected function generateCsrfToken($form_name)
	{
		$key = 'csrf_tokens/' . $form_name;
		$tokens = $this->session->get($key,array());
		if (count($tokens) >= 10) {
			array_shift($tokens);
		}

		$token = sha1($form_name . session_id() . microtime());
		$tokens[] = $token;

		$this->session->set($key,$tokens);

		return $token;
	}

	protected function checkCsrfToken($form_name, $token)
	{
		$key = 'csrf_tokens/' . $form_name;
		$tokens = $this->session->get($key, array());

		if (false !== ($pos = array_search($token, $tokens, true))) {
			unset($tokens[$pos]);
			$this->session->set($key, $tokens);

			return true;
		}
		return false;
	}


protected function pager_search($sql)
{
		//インストールしたPEARのPagerライブラリを読み込む
		require_once("Pager/Pager.php");

		//1ページあたりに表示するデータ数
		$pagelength = "10";

		//データを格納する配列
		$data_array=array();

		//SQLを実行する
		$list = $this->db_manager->get('Status')->fetchAll($sql);

		//データ数を取得する
		$total = count($list);

		//ページャーライブラリに渡す設定（パラメーター
		$page=array(
				"itemData"=>$list,  //アイテムの配列です。
				"totalItems"=>$total, //合計アイテム数
				"perPage"=>$pagelength, //１ページあたりの表示数
				"mode"=>"Jumping",
				"linkClass" => "list",
				"curPageLinkClassName" => "list",
				"altFirst"=>"First", //以下、文字表示設定　１ページ目のalt表示
				"altPrev"=>"", //前のalt
				'prevImg'=>"&lt;&lt; prev", //前へ　の文字表示
				"altNext"=>"", //次へ　のalt
				"nextImg"=>"next &gt;&gt;", //次へ　の文字表示
				"altLast"=>"Last", //ラストのalt表示
				"altPage"=>"",
				"separator"=>" ", //数字と数字の間の文字
				"append"=>1,
				"urlVar"=>"page",//get属性
		);

		//Pagerに設定した項目を読み込ませます
		$pager= Pager::factory($page);

		//現在のページ配列（戻り値）を取得
		$data_array['data'] = $pager->getPageData();
		//ページ遷移のリンクリストを取得
		$data_array['links'] = $pager->links;
		$data_array['total'] = $pager->numItems();
		//データ配列を返す
		return $data_array;

	}
}