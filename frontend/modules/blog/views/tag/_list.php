<?php
//$url = "/blog/" . $model->url;
echo '<a href="/blog/tag/' . str_replace(' ', '_', $model->name) . '">' . $model->name . '</a><br />';