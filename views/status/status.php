    <div class="status">
        <div class="status_content">
            <table>
                <tr>
                    <th>タスク名</th>
                    <th>期限</th>
                    <th>ステータス</th>
                    <th>操作</th>
                </tr>
                <tr>
                    <td><?php echo $this->escape($status['task_name']); ?></td> <!--escapeはviewクラスのメソッド-->
                    <td><?php echo $this->escape($status['deadline']); ?></td>
                    <td><?php echo $this->escape($status['status_name']); ?></td>
                    <td><a href="<?php echo $base_url; ?>/deleta/<?php echo $this->escape($status['id']); ?>">編集</a></td><!--ここにtasksのIDをくっつける-->
                    <td><a href="<?php echo $base_url; ?>">削除</a></td>
                </tr>
            </table>

        </div>

    </div>