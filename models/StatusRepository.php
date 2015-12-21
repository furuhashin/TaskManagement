<?php

class StatusRepository extends DbRepository
{
    public function insert($task_name,$user_id,$status_id,$dead_line)
    {

        $sql = "INSERT INTO tasks(task_name, user_id,status_id, deagline) VALUES(:task_name,:user_id, :status_id, :deadline)";

        $stmt = $this->execute($sql, array(
            ':task_name' => $task_name,
            ':user_id' => $user_id,
            ':status_id' => $status_id,
            ':dead_line' => $dead_line,
        ));
    }

    public function fetchAllTaskName()
    {
        $sql = "SELECT task_name, status_id, deadline FROM tasks";
        return $this->fetchAll($sql);
    }

    public function fetchStatusId()
    {
        $sql = "SELECT * FROM status";
        return $this->fetchAll($sql);
    }



//    public function fetchAllPersonalArchivesByUserId($user_id)
//    {
//        $sql = "SELECT a.*, u.user_name FROM status a
//LEFT JOIN user u ON a.user_id = u.id
//LEFT JOIN following f ON f.following_id = a.user_id
//AND f.user_id = :user_id
//WHERE f.user_id = :user_id OR u.id = :user_id
//ORDER BY a.created_at DESC";
//
//        return $this->fetchAll($sql,array(':user_id' => $user_id));
//    }

//    public function fetchAllByUserId($user_id)
//    {
//        $sql = "SELECT a.*, u.user_name FROM status a LEFT JOIN user u ON a.user_id = u.id
//WHERE u.id = :user_id
//ORDER BY a.created_at DESC";
//        return $this->fetchAll($sql,array(':user_id' => $user_id));
//    }

//    public function fetchByIdAndUserName($id,$user_name)
//    {
//        $sql = "SELECT a.*, u.user_name FROM status a LEFT JOIN user u ON u.id = a.user_id
//WHERE a.id = :id
//AND u.user_name = :user_name";
//
//        return $this->fetch($sql,array(
//            ':id' => $id,
//            ':user_name' => $user_name,
//        ));
//    }
}