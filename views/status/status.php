    <div class="status">
        <div class="status_content">


                        <tr>
                            <td><?php echo $this->escape($status['task_name']); ?></td> <!--escapeはviewクラスのメソッド-->
                            <td><?php echo $this->escape($status['deadline']); ?></td>
                            <td><?php echo $this->escape($status['status_name']); ?></td>
                            <td><a href="<?php echo $base_url; ?>/status/edit_rend/<?php echo $this->escape($status['id']); ?>">編集</a></td><!--ここにtasksのIDをくっつける-->
                            <td><a href="<?php echo $base_url; ?>/status/delete_preview/<?php echo $this->escape($status['id']); ?>">削除</a></td>
                        </tr>



        </div>

    </div>