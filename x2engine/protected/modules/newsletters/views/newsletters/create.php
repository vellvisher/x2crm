<?php
$this->actionMenu = $this->formatMenu(array(
    array('label'=> 'List Newsletters', 'url'=>array('index')),
    array('label'=> 'Create Newsletter')
));

?>
<div class="page-title icon newsletters">
    <h2>
    <?php
        echo 'Create Newsletter';
    ?>
    </h2>
</div>

<?php
echo $this->renderPartial('_form', array('model'=>$model));
