<?php if(!$_['buttonsDisplay']) { ?>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0">
<script type="text/javascript" src="/core/js/jquery-1.10.0.min.js"></script>
<link rel="stylesheet" href="<?php p($_['appPath'].'css/popup.css')?>">
<script type="text/javascript" src="<?php p($_['appPath'].'js/popup_util.js')?>"></script>
<script type="text/javascript" src="<?php p($_['appPath'].'js/popup.js')?>"></script>
<input type="hidden" id="currentUser" value="<?php p($_['currentUser'])?>">
<?php } ?>
<div id="agree">
<?php echo $_['content']; ?>
<?php if($_['buttonsDisplay']) { ?>
<div class="buttons">
    <span>사용자 보안 수칙에 동의하였음</span><input type="checkbox" name="agree" class="agree">
</div>
<?php } else { ?>
<div class="closeOption">
    <span>7일 간 팝업 열지 않음</span><input type="checkbox" name="notOpenUtil7days" class="notOpenUtil7days">
    <span class="close">닫기</span>
</div>
<?php } ?>
</div>