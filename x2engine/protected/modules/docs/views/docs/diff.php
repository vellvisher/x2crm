<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.form.min.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/codemirror.js');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/codemirror.css');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/mergely.js');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/mergely.css');
?>

<script>
    $(function() {
        revIdArray = <?php echo $revIdArray ?>;
        $(".view").click(function() {
            var id = $(this).attr('id');
            var prevId = undefined;
            if (id != 0)
                prevId = revIdArray[revIdArray.indexOf(id)-1];
            if (id) {
                var url = "<?php echo $this->createUrl('/docs/docs/fullViewRevision/') ?>"+"/"+id;
                $.get(url, function(data) {
                    $('#compare').mergely('rhs', atob(data));
                });
            } else {
                $('#compare').mergely('rhs', "");
            }
            if (prevId) {
                var prevUrl = "<?php echo $this->createUrl('/docs/docs/fullViewRevision/') ?>"+"/"+(prevId);
                $.get(prevUrl, function(data) {
                    $('#compare').mergely('lhs', atob(data));
                });
            } else {
                $('#compare').mergely('lhs', "");
            }
            console.log(id, prevId);
        });
    });
</script>


<div id="revList" class="action list-view" style="cursor:pointer">
    <div class="items" style="overflow:scroll;height:300px">
    <?php foreach ($revList as $rev) { ?>
        <div class="view" id="<?php echo $rev['id'] ?>">
            <span>
                <?php echo $rev['fullName']; ?>
            </span>
            <span>
                <?php echo $rev['date']; ?>
            </span>
        </div>
    <?php } ?>
    </div>
</div>

<br/>
<br/>
<div id="compare"></div>

<script>
$(document).ready(function () {
    $('#compare').mergely({
        cmsettings: { readOnly: true, lineNumbers: true, lineWrapping:true },
        lhs: function(setValue) {
                    setValue('');
                },
        rhs: function(setValue) {
                    setValue('');
                }
    });
});
</script>
