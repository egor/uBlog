<?php
use frontend\widgets\altControl\ALTControlWidget;

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Blog'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $blog['menu_name'];
?>
<div class="row">
    <div class="col-lg-12">
<article>
    <!-- Post header-->
    <header class="mb-4">
        <!-- Post title-->
        <h1 class="fw-bolder mb-1"><?php echo $blog['header'] . ALTControlWidget::widget(['method' => 'editPanel', 'data' => ['module' => 'blog', 'id' => $blog['id']]]); ?></h1>
    </header>
    <!-- Preview image figure-->
    <figure class="mb-4"><img class="img-fluid rounded" src="https://dummyimage.com/1290x400/ced4da/6c757d.jpg" alt="..." /></figure>
    <!-- Post content-->
    <section class="mb-5">
        <?php
        echo $blog['text'];
        ?>
    </section>
</article>
    </div>
</div>