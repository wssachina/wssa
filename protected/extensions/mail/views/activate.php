<?php
$style = 'padding-top:13px;padding-left:39px;padding-right:13px;padding-bottom:13px;text-align:left;border-bottom:1px solid #ddd';
?>
<tr>
	<td style="<?php echo $style; ?>">
		<p><strong>亲爱的<?php echo $user->name_zh ?: $user->name; ?>：</strong></p>
		<p>请点击以下链接激活账户，该链接24小时有效。</p>
		<p><a href="<?php echo $url; ?>"><?php echo $url; ?></a></p>
		<p>如果不能点击，请复制该链接，粘帖到地址栏进行重设。</p>
		<p>如非本人操作，请忽略该邮件。</p>
		<p>本邮件由系统自动发出，请勿回复，如有疑问，请联系<?php echo Yii::app()->params->adminEmail; ?>。</p>
	</td>
<tr>
