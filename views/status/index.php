<?php if ($session->isAuthenticated()): ?>

<h2>タスク一覧</h2>
<a href="<?php echo $base_url; ?>/status/insert_rend">新規追加</a>
<form action = "<?php echo $base_url; ?>/status/post" method="post">
    <input type="hidden" name="_token" value="<?php echo $this->escape($_token); ?>" />

    <?php if (isset($errors) && count($errors)>0): ?>
        <?php echo $this->render('errors',array('errors' => $errors)); ?>
    <?php endif; ?>

</form>

<div id="statuses">
    <table  class="tablesorter">
        <thead>
        <tr>
            <th>タスク名</th>
            <th>期限</th>
            <th>ステータス</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
    <?php foreach($statuses['data'] as $status): ?>
    <?php echo $this->render('status/status', array('status' => $status)); ?>
    <?php endforeach; ?>
        <?php echo '<div class="pager">';
            echo $statuses['links'];
            echo '</div>'; ?>
        </tbody>
    </table>
</div>
<?php endif; ?>