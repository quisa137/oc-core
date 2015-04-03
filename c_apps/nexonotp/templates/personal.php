<div id="nexonotp" class="section">
<?php
$arrayList = $_['list_array'];
if(!is_array($arrayList) || empty($arrayList)):
	$arrayList = array();
endif;
?>
<h2><?php p($l->t('Recent Login')) ?></h2>
<table class="lastloginTb">
<tr>
	<th>접속 아이피</th>
	<th>접속 시간</th>
</tr>
<colgroup>
	<col class="userip"/>
	<col class="time"/>
</colgroup>
<?php
if(count($arrayList)>0):
	foreach ($arrayList as $row): ?>
	<tr>
		<td><?php p($row['userip'])?></td>
		<td><?php p(\OCP\Util::formatDate($row['timestamp']))?></td>
	</tr>
	<?php endforeach;
else:
?>
<?php
endif; ?>
</table>
</div>