<?php

$this->title = $page['meta_title'];
$this->registerMetaTag(['name' => 'description', 'content' => $page['meta_description']]);
$this->registerMetaTag(['name' => 'keywords', 'content' => $page['meta_keywords']]);
$this->params['breadcrumbs'][] = $page['menu_name'];
?>
<div class="error-index">
    <div class="p-5 mb-4 bg-transparent rounded-3">
        <div class="container-fluid py-5 text-center">
            <h1 class="display-4"><?php echo $page['header']; ?></h1>
        </div>
    </div>

    <div class="body-content">
        <?php echo $page['text']; ?>
    </div>
</div>