<?php $this->setLayoutVar('title','ホーム') ?>

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
    <?php foreach($statuses as $status): ?><!--$statusesはStatusControllerクラスで生成される※ここで出力がループする-->
    <?php echo $this->render('status/status', array('status' => $status)); ?><!--viewクラスのrender()※controllerクラスではない-->
    <?php endforeach; ?>
        </tbody>
    </table>
</div>
