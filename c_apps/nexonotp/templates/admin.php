<div id="nexonotp" class="section">
<?php 
$ips = unserialize($_['internal_ip']);
$content = $_['content'];
$secureAlarm = $_['secureAlarm'];
$settings = $_['settings'];
$host = $_['host'];
$port = $_['port'];
if(!is_array($ips) || empty($ips)):
	$ips = array();
endif;
?>
<h2><?php p($l->t('Nexon OTP Extension')) ?></h2>
<input type="checkbox" name="secureAlarm" value="1" <?php p($secureAlarm==='true'?'checked':''); ?> >보안 수칙 게시
<br>
<textarea name="content" style="width:60%;height:200px;" <?php p($secureAlarm==='true'?'':'disabled'); ?> ><?php p($content)?></textarea>
<br><br>
<p><label><?php p($l->t('Host')) ?> : </label><input type="text" name="host" value="<?php p($host)?>" style="width:400px"></p>
<p><label><?php p($l->t('Port')) ?> : </label><input type="text" name="port" value="<?php p($port)?>"></p>
<p><?php p($l->t('Internal IP List(eg:1.234.123.12/24)')) ?></p>
<p><?php p($l->t('if empty list, OTP required to all users.')) ?></p>
<input type="button" name="nexonotp_add_row" value="<?php p($l->t('IP Add')) ?>"/>
<ul id="nexonotp_ip_list">
<?php
if(count($ips)>0):
	foreach ($ips as $ip): ?>
		<li><input type="text" name="internal_ip[]" value="<?php p($ip)?>"/><input type="button" name="nexonotp_delete_row"  value="-"/></li>
	<?php endforeach;
else:
?>
<?php
endif; 
?>
</ul>
<br /><button type="button" id="nexonotp_save"><?php p($l->t('Save')) ?></button>
<?php /*
<table>
    <tr>
        <th>설정 이름</th>
        <th>아이피 대역</th>
        <th>제어</th>
    </tr>
    <tbody id="settings">
    <?php
    if(count($settings)>0) {
        foreach($seettings as $setting) {
    ?>
            <tr>
                <td><?php p($setting['settingName'])?></td>
                <td><?php p($setting['ipRange'])?></td>
                <td><a href="#" class="modify"><?php p($l->t('Modify')) ?></a> <a href="#" class="delete"><?php p($l->t('Delete')) ?></a></td>
            </tr>
    <?php
        }
    } else {
    ?>
            <tr><td colspan="3"><?php p($l->t('Settings Not exists.')) ?></td></tr>
    <?php
    }
    ?>
    </tbody>
</table>
*/
?>
<!--
<table id="settingTables" class="settingTable">
<thead>
    <tr>
        <th>아이피 대역</th>
        <th>역 적용</th>
        <?php /* 해당 대역에 대해 지정하는지, 대역을 제외하고 지정할지 여부*/ ?>
        <th>보안수칙노출</th>
        <th>업로드 차단 확장자</th>
        <th>Agent 접속 차단</th>
        <th>모바일 앱 접속 차단</th>
        <th>OTP 로그인 강제</th>
        <th>버튼</th>
    </tr>
    <colgroup>
        <col width="">
        <col width="">
        <col width="">
        <col width="">
        <col width="">
        <col width="">
        <col width="">
        <col width="">
    </colgroup>
</thead>
<tbody>
    <tr>
        <td><input type="text" name="ip_range"></td>
        <td><input type="radio" name="inout" value="in">대역<input type="radio" name="inout" value="out">대역제외</td>
        <td><input type="checkbox" name="notify_Instructions"></td>
        <td><input type="text" name="blockTypes"></td>
        <td><input type="checkbox" name="agentBlock"></td>
        <td><input type="checkbox" name="mobileAppBlock"></td>
        <td><input type="checkbox" name="requireOTPLogin"></td>
        <td><input type="button" name="nexonotp_delete_row"  value="-"/></td>
    </tr>
</tbody>
</table>
-->
</div>