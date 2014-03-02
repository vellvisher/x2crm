<div id="chat-widget-wrapper" style="width:99%">
    <div id="chat-widget-container">

        <p>
        <a href="<?php echo $invite_url;?>">Invite</a>
        </p>

        <?php foreach($users as $user) { ?>
            <span><strong><?php echo $user['fullName'];?></strong>
            <?php foreach ($user['invites'] as $chatInvite) { ?>
            <?php echo CHtml::form($join_url, 'post', array('target'=>'_blank')); ?>
            <input type="hidden" name="chatroom_id" value="<?php echo $chatInvite['chatroom_id']; ?>"></input>
                <input type="submit" value="Join"></input>
                </form>
            <?php } ?>
            </span>
        <?php } ?>
    </div>
</div>
