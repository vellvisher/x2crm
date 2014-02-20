<div class="page-title">
	<h2 style="padding-left:0">Plugins</h2>
</div>
<div class="form">
	<table cellspacing="0">
		<thead>
			<tr>
				<th scope="col"></th>
				<th scope="col">Plugin</th>
				<th scope="col">Description</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<th scope="col"></th>
				<th scope="col">Plugin</th>
				<th scope="col">Description</th>
			</tr>
		</tfoot>
		<tbody>
			<?php foreach($plugins as $plugin) { ?>
			<tr>
				<th scope="row">
				</th>
				<!--<td class="plugin-title"><strong>BulletProof Security</strong><div class="row-actions visible"><span class="activate"><a href="#" title="Activate this plugin" class="edit">Activate</a> | </span><span class="delete"><a href="#" title="Delete this plugin" class="delete">Delete</a></span></div></td>
				<td class="column-description desc">
						<div class="plugin-description"><p>Website Security Protection: BulletProof Security protects your website against XSS, RFI, CRLF, CSRF, Base64, Code Injection and SQL Injection hacking attempts. One-click .htaccess WordPress security protection. Protects wp-config.php, bb-config.php, php.ini, php5.ini, install.php and readme.html with .htaccess security protection.  Security Logging. HTTP Error Logging. One-click Website Maintenance Mode (HTTP 503). Additional website security checks: DB errors off, file and folder permissions check... System Info: PHP, MySQL, OS, Server, Memory Usage, IP, SAPI, DNS, Max Upload... Built-in .htaccess file editing, uploading and downloading.</p></div>
						<div class="inactive second plugin-version-author-uri">Version .48 | By <a href="#" title="Visit author homepage">AITpro | Edward Alexander</a> | <a href="#" title="Visit plugin site">Visit plugin site</a></div></td>-->
				<td><?php if($plugin->activated) { ?><a href="<?php echo Yii::app()->controller->createUrl("/profile/plugins?action=deactivate&id=".$plugin->id); ?>">Deactivate</a><?php } else { ?><a href="<?php echo Yii::app()->controller->createUrl("/profile/plugins?action=activate&id=".$plugin->id); ?>">Activate</a><?php } ?></td>
				<td><?php echo $plugin->name; ?></td>
				<td><?php echo $plugin->description; ?></td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
</div>