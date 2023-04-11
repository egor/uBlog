<?php
$this->title = $page['meta_title'];
?>
<div class="site-index">
    <div class="p-5 mb-4 bg-transparent rounded-3">
        <div class="container-fluid py-5 text-center">
            <h1 class="display-4"><?php echo $page['header']; ?></h1>
        </div>
    </div>

    <div class="body-content">
        <?php
        echo $page['text'];
        ?>


    </div>
</div>
