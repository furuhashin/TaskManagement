<?php

class UserRepository extends DbRepository
{
	public function insert($user_name, $password)
	{
		$password = $this->hashPassword($password);
		//$now = new DateTime();//定義済みクラス

		$sql = "INSERT INTO user(user_name, password) VALUES(:user_name, :password)";
		$stmt = $this->execute($sql, array(
			':user_name' => $user_name,
			':password' => $password,
			));
	}

	public function Password($password)
	{
		return $password;
	}

	public function fetchByUserName($user_name)
	{
		$sql = "SELECT * FROM user WHERE user_name = :user_name";
		return $this->fetch($sql, array(':user_name' => $user_name));
	}

	public function isUniqueUserName($user_name)
	{
		$sql = "SELECT COUNT(user_id) as count FROM user WHERE user_name = :user_name";

		$row = $this->fetch($sql, array(':user_name' => $user_name));
		if ($row['count'] === '0') {
			return true;
		}
		return false;
	}

}