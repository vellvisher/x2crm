<div class="page-title">
	<h2 style="padding-left:0">Plugins</h2>
</div>
<div class="form">
	<style type="text/css">
	.info, .success, .warning, .error, .validation {
	border: 1px solid;
	margin: 10px 0px;
	padding:15px 10px 15px 50px;
	background-repeat: no-repeat;
	background-position: 10px center;
	}
	.info {
	color: #00529B;
	background-color: #BDE5F8;
	background-image: url('info.png');
	}
	.success {
	color: #4F8A10;
	background-color: #DFF2BF;
	background-image:url('success.png');
	}
	.warning {
	color: #9F6000;
	background-color: #FEEFB3;
	background-image: url('warning.png');
	}
	.error {
	color: #D8000C;
	background-color: #FFBABA;
	background-image: url('error.png');
	}
	.plugins th {
		font-weight: bold;
	}
	.plugins tr {
		padding-bottom: 10px;
	}
	</style>
	<?php if(isset($messages['error'])) { ?>
		<div class="error"><?php echo $messages['error']; ?></div>
	<?php } elseif(isset($messages['success'])) { ?>
		<div class="success"><?php echo $messages['success']; ?></div>
	<?php } ?>
	<table cellpadding="5" class="plugins">
		<thead>
			<tr>
				<th scope="col" width="5%">&nbsp;</th>
				<th scope="col" width="10%">Plugin</th>
				<th scope="col" width="80%">Description</th>
				<th scope="col" width="5%">&nbsp;</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<th scope="col">&nbsp;</th>
				<th scope="col">Plugin</th>
				<th scope="col">Description</th>
				<th scope="col">&nbsp;</th>
			</tr>
		</tfoot>
		<tbody>
			<?php foreach($plugins as $plugin) { ?>
			<tr>
				<!--<td class="plugin-title"><strong>BulletProof Security</strong><div class="row-actions visible"><span class="activate"><a href="#" title="Activate this plugin" class="edit">Activate</a> | </span><span class="delete"><a href="#" title="Delete this plugin" class="delete">Delete</a></span></div></td>
				<td class="column-description desc">
						<div class="plugin-description"><p>Website Security Protection: BulletProof Security protects your website against XSS, RFI, CRLF, CSRF, Base64, Code Injection and SQL Injection hacking attempts. One-click .htaccess WordPress security protection. Protects wp-config.php, bb-config.php, php.ini, php5.ini, install.php and readme.html with .htaccess security protection.  Security Logging. HTTP Error Logging. One-click Website Maintenance Mode (HTTP 503). Additional website security checks: DB errors off, file and folder permissions check... System Info: PHP, MySQL, OS, Server, Memory Usage, IP, SAPI, DNS, Max Upload... Built-in .htaccess file editing, uploading and downloading.</p></div>
						<div class="inactive second plugin-version-author-uri">Version .48 | By <a href="#" title="Visit author homepage">AITpro | Edward Alexander</a> | <a href="#" title="Visit plugin site">Visit plugin site</a></div></td>-->
				<td><?php if($plugin->activated) { ?><a href="<?php echo Yii::app()->controller->createUrl("/profile/plugins?action=deactivate&id=".$plugin->id); ?>">Deactivate</a><?php } else { ?><a href="<?php echo Yii::app()->controller->createUrl("/profile/plugins?action=activate&id=".$plugin->id); ?>">Activate</a><?php } ?></td>
				<td><?php echo $plugin->name; ?></td>
				<td><?php echo $plugin->description; ?></td>
				<td><a href="<?php echo Yii::app()->controller->createUrl("/profile/plugins?action=delete&id=".$plugin->id); ?>">Delete</a></td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
	<p><form action="<?php echo Yii::app()->controller->createUrl("/profile/plugins?action=upload"); ?>" method="post" enctype="multipart/form-data">
		<label for="file">Upload Plugin:</label>
		<input type="file" name="file" id="file"><br>
		<input type="submit" name="submit" value="Submit">
	</form><br />Download plugins from the <a href="/dashboard.php" target="_blank">X2CRM Plugins Dashboard</a></p>
</div>