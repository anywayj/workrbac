<?php 
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Html;
?>
<?php // if (\Yii::$app->user->can('admin', ['author_id' => $model->user_id])): ?>
<?php if (\Yii::$app->user->can('admin')): ?>
<div class="admin-default-index">
    <div class="container">
        <div class="col-lg-3"> 
            <div class="list-group">
                <a href="#" class="list-group-item active">
                    <span class="glyphicon glyphicon-star"></span> Управление
                </a>
                <a href="/admin/user/index" class="list-group-item">
                    <span class="glyphicon glyphicon-user"></span> Пользователи
                </a>
                <a href="/admin/authassignment/index" class="list-group-item">
                    <span class="glyphicon glyphicon-education"></span> Правила доступу
                </a>
            </div>  
        </div> 
    </div>
</div>
<?php elseif (\Yii::$app->user->can('manager')): ?>
    <?php echo ("Логин: " . \Yii::$app->user->identity->username . ". Нет доступа") ?>
<?php endif; ?>