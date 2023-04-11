<?php
$url = "/blog/" . $model->url;
?>
<div class="card p-3 mt-2 mb-3">
    <div class="row">
        <div class="col-md-4">
            <div class="position-relative snipimage">
                <a href="<?php echo $url ?>"><img src="https://dummyimage.com/400x400/ced4da/6c757d.jpg" class="rounded img-fluid w-100 img-responsive"></a>
                <span class="position-absolute user-timing"><?php echo date('d.m.Y H:i', $model->displayed_at); ?></span>
            </div>
        </div>
        <div class="col-md-8">
            <div class="mt-2">
                <div class="d-flex justify-content-between align-items-center">
                    <h2 class="mb-1"><a href="<?php echo $url ?>"><?php echo $model->header; ?></a>
                        <?php echo \frontend\widgets\altControl\ALTControlWidget::widget(['method' => 'editPanel', 'data' => ['module' => 'blog', 'id' => $model->id]]); ?>
                    </h2>
                </div>
                <div class="">
                    <?php echo $model->short_text; ?>
                    <br />
                    <a href="<?php echo $url ?>" class="btn btn-light position-absolute bottom-0 end-0" style="right: 15px!important; bottom: 15px!important;"><?php echo Yii::t('app', 'Detail'); ?></a>
                </div>
            </div>
        </div>
    </div>
</div>