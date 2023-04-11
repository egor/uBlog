<?php
use yii\widgets\ListView;

$this->title = $page['meta_title'];
$this->registerMetaTag(['name' => 'description', 'content' => $page['meta_description']]);
$this->registerMetaTag(['name' => 'keywords', 'content' => $page['meta_keywords']]);
$this->params['breadcrumbs'][] = $page['menu_name'];
?>
<div class="blog-index">
    <div class="p-5 mb-4 bg-transparent rounded-3">
        <div class="container-fluid py-5 text-center">
            <h1 class="display-4"><?php echo $page['header']; ?></h1>
        </div>
    </div>

    <?php
    if (empty($_GET['page']) || $_GET['page'] == 1) {
    ?>
    <div class="body-content">
        <?php echo $page['text']; ?>
    </div>
    <?php
    }
    ?>
</div>

<?php
echo ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView' => '_list',
    'pager' => [
        'class' => 'yii\bootstrap5\LinkPager',
    ]
]);