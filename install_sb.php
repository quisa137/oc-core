<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>Securebox 설치</title>
    <script type="text/javascript" src="/core/js/jquery-1.10.0.min.js"></script>
    <script type="text/javascript" src="/vendor/twbs/bootstrap/dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="/vendor/twbs/bootstrap/dist/css/bootstrap.min.css"/>
    <style>
    body{
        text-align: center;
    }
    .wrapper{
        margin: 0 auto;
        width: 60%;
    }
    .checkbox{
        min-height: 27px;
        position: relative;
        display: block;
        padding-top: 7px;
        margin-top: 0;
        margin-bottom: 0;
        box-sizing:border-box;
        text-align: left;
    }
    .help-block{
        text-align: left;
    }
    .radio label, .checkbox label {
        min-height: 20px;
        padding-left: 20px;
        margin-bottom: 0;
        font-weight: normal;
        cursor: pointer;
        display: inline-block;
        max-width: 100%;
    }
    .form-horizontal .control-label {
        text-align: left;
    }
    .waiting {
        background-image: url(http://localhost/core/img/loading-small.gif);
        width: 16px;
        height: 16px;
        background-repeat: NO-REPEAT;
        margin: auto;
    }
    </style>
    <script type="text/javascript">
    $(function(){
        $('.btn-success').click(function(e){
            e.preventDefault();
            var value = [];
            var input = $('[name="installPackages"]:checked').each(function(i,item){
                value.push($(item).val());
            });
            if(value.length>0) {
                $.post('install_sb_back.php',{'installpackages':value.join(",")},function(res){
                    $('#buttons').removeClass('waiting');
                    $('#buttons').append('<button class="btn btn-success">설치</button>');
                    for(key in res) {
                        $('#result').append(key+' : '+res[key]+'<BR>');
                    }
                    
                });
                $('.btn-success').remove();
                $('#buttons').addClass('waiting');
            }
        });
    });
    </script>
</head>
<body>
<div class="wrapper">
    <h1>패키지 선택</h1>
    <form action="" class="form form-horizontal" method="POST">
    <?php /*
        <div class="form-group installpackages">
            <label class="control-label col-sm-6" for="installpackages">Test</label>
            <div class="col-sm-6">
                <div id="installpackages-type">
                    <div class="checkbox"><label><input type="checkbox" name="installPackages" value="test"></label></div>
                </div>
                <div class="help-block">Test</div>
            </div>
        </div>
    */ ?>
        <div class="form-group installpackages">
            <label class="control-label col-sm-6" for="installpackages">Securebox Security Extension</label>
            <div class="col-sm-6">
                <div id="installpackages-type">
                    <div class="checkbox"><label><input type="checkbox" name="installPackages" value="sbotp"></label></div>
                </div>
                <div class="help-block">Securebox 보안 확장 플러그인 입니다 </div>
            </div>
        </div>
        <div class="form-group installpackages">
            <label class="control-label col-sm-6" for="installpackages">Securebox Data Collector</label>
            <div class="col-sm-6">
                <div id="installpackages-type">
                    <div class="checkbox"><label><input type="checkbox" name="installPackages" value="sbdatacollector"></label></div>
                </div>
                <div class="help-block">Securebox에 필요한 데이터를 전달하는 플러그인 입니다 </div>
            </div>
        </div>
        <div class="form-group installpackages">
            <label class="control-label col-sm-6" for="installpackages">Securebox Monitoring System(Developing)</label>
            <div class="col-sm-6">
                <div id="installpackages-type">
                    <div class="checkbox"><label><input type="checkbox" name="installPackages" value="sbmonitoring" disabled></label></div>
                </div>
                <div class="help-block">Securebox의 모니터링 시스템입니다 개발중</div>
            </div>
        </div>
        <div class="form-group installpackages">
            <label class="control-label col-sm-6" for="installpackages">Securebox Legacy DB System(Developing)</label>
            <div class="col-sm-6">
                <div id="installpackages-type">
                    <div class="checkbox"><label><input type="checkbox" name="installPackages"  value="sblegacyDBsupport" disabled></label></div>
                </div>
                <div class="help-block">Securebox의 Legacy 지원 시스템 입니다</div>
            </div>
        </div>
        <div class="form-group installpackages">
            <label class="control-label col-sm-6" for="installpackages">Securebox End To End(Developing)</label>
            <div class="col-sm-6">
                <div id="installpackages-type">
                    <div class="checkbox"><label><input type="checkbox" name="installPackages" value="sbetoe" disabled></label></div>
                </div>
                <div class="help-block">Securebox의 End To End 서버 입니다</div>
            </div>
        </div>
        <!--
        <div class="form-group installpackages">
            <label class="control-label col-sm-4" for="installpackages">패키지</label>
            <div class="col-sm-8">
                <div id="installpackages-type">
                    <div class="checkbox"><label><input type="checkbox" name="installPackages" value="securebox">Securebox</label></div>
                    <div class="checkbox"><label><input type="checkbox" name="installPackages" value="sbotp"> Securebox Security Extension</label></div>
                    <div class="checkbox"><label><input type="checkbox" name="installPackages" value="sbdatacollector">Securebox Data Collector</label></div>
                    <div class="checkbox"><label><input type="checkbox" name="installPackages" value="sbmonitoring" disabled> Securebox Monitoring System(Developing)</label></div>
                    <div class="checkbox"><label><input type="checkbox" name="installPackages" value="sblegacyDBsupport" disabled> Securebox Legacy DB System(Developing)</label></div>
                    <div class="checkbox"><label><input type="checkbox" name="installPackages" value="sbetoe" disabled> Securebox End To End(Developing)</label></div>
                </div>
                <div class="help-block help-block-error "></div>
            </div>
        </div>
        -->
        <div id="buttons">
            <button class="btn btn-success">설치</button>
        </div>
        <div id="result"></div>
    </form>
</div>
</body>
</html>