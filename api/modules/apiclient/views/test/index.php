<?php

use yii\helpers\Html;
?>
<div class="row">
    <div class="col-xs-12">
        <?php
            echo Html::a("GET Requests/",['/apiclient/test/requests'],['class'=>'btn btn-primary']);
        ?>
    </div>
</div>

<div class="row">
    <div class="col-xs-12">

            <?php
                if(isset($answers)){
                    echo "<pre>";
                        print_r($answers);
                    echo "</pre>";
                }
            ?>
    </div>
</div>