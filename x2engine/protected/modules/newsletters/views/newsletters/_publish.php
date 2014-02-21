<div id="publish-dialog" title="Basic dialog" style="display:none;">
    <form action='<?php echo $action;?>' method="post">
        <table>
            <tr>
                <td><label>Start Date</label></td>
                <td><input type="text" id="startDate" name="startDate"/></td>
            </tr>
            <tr>
                <td><label>End Date</label></td>
                <td><input type="text" id="endDate" name="endDate"/></td>
            </tr>
            <tr>
                <td><label>Type</label></td>
                <td>
                    <select id="type" name="type">
                        <?php foreach ($model->types as $id=>$type) echo "<option value='$id'>$type</option>"; ?>
                    </select>
            </tr>
        </table>
        <div>
            <input type="submit" class="x2-button float" value="Publish"/>
        </div>
    </form>
</div>