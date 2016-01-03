<?php

class StatusRepository extends DbRepository
{
    public function insert($task_name,$user_id,$status_id,$deadline)
    {

        $sql = "INSERT INTO tasks(task_name, user_id,status_id, deadline) VALUES(:task_name,:user_id,:status_id, :deadline)";

        $stmt = $this->execute($sql, array(
            ':task_name' => $task_name,
            ':user_id' => $user_id,
            ':status_id' => $status_id,
            ':deadline' => $deadline,
        ));
    }

    public function fetchAllTaskName()
    {
        $sql = "SELECT id, task_name, status_name, deadline FROM tasks LEFT JOIN status ON tasks.status_id=status.status_id";
        return $this->fetchAll($sql);
    }

    public function fetchStatusId()
    {
        $sql = "SELECT * FROM status";
        return $this->fetchAll($sql);
    }

    public function delete($id)
    {

        $sql = "DELETE FROM tasks WHERE id = :id";

        $stmt = $this->execute($sql, array(
            ':id' => $id,
        ));
    }

    public function edit($task_name,$status_id,$deadline,$id)
    {

        $sql = "UPDATE tasks SET task_name =:task_name, status_id = :status_id, deadline = :deadline WHERE id = :id";

        $stmt = $this->execute($sql, array(
            ':task_name' => $task_name,
            ':status_id' => $status_id,
            ':deadline' => $deadline,
            ':id' => $id,
        ));
    }

   public function fetchTaskById($id)
    {
        $sql = "SELECT * FROM tasks LEFT JOIN status ON tasks.status_id = status.status_id
WHERE tasks.id = :id";

        return $this->fetch($sql,array(
            ':id' => $id,
        ));
    }

    public function DbCount()
    {
        $sql = "SELECT COUNT(*) FROM tasks";

        return $this->fetch($sql);

    }



}