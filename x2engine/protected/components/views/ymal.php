<div id="ymal-widget-wrapper" style="width:99%">
    <div id="ymal-widget-content" style="background:#fcfcfc; border: 1px solid #ddd;padding:0 4px">

    <?php foreach($topPostsText as $post) { ?>
        <div class="ymal-message" style="font-size:9pt">
        <span style="word-wrap:break-word">
            <br/>
            <?php
                echo Formatter::convertLineBreaks($post);
            ?>
            <br/>
        </span>
        </div>
    <?php } ?>
    </div>
</div>
