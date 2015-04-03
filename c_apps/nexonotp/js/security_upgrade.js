/**
 * 윈도우가 닫힐 때, 자동으로 로그아웃
 */
//$(window).unload(function(e){
//    $.get('/index.php',{logout:'true',requesttoken:OC.get('oc_requesttoken')},function(res){return;})
//});

$(function(){
    //링크 공유 시 비밀번호 보안성 평가
    $('#fileList').on('focus','#linkPassText',function(e){
        var t = $(e.currentTarget)
        var pwcheckDIV = '<div id="passwordChecker"></div>';
        if(t.parent().find('#passwordChecker').length<=0) {
            t.after(pwcheckDIV).next().hide(); 
        }else{
            t.parent().find('#passwordChecker').html('').hide();
        }
    }).on('change','#linkPassText',function(e){
        var t = $(e.currentTarget),val = t.val();
        var desc = new Array();
        
        desc[0] = "매우 약함";
        desc[1] = "약함";
        desc[2] = "조금 약함";
        desc[3] = "평이";
        desc[4] = "강력";
        desc[5] = "아주 강력";

        var score   = 0;

        //if txtpass bigger than 6 give 1 point
        if (val.length > 6) score++;

        //if txtpass has both lower and uppercase characters give 1 point
        if ( ( val.match(/[a-z]/) ) && ( val.match(/[A-Z]/) ) ) score++;

        //if txtpass has at least one number give 1 point
        if (val.match(/\d+/)) score++;

        //if txtpass has at least one special caracther give 1 point
        if ( val.match(/.[!,@,#,$,%,^,&,*,?,_,~,-,(,)]/) ) score++;

        //if txtpass bigger than 12 give another 1 point
        if (val.length > 12) score++;
         
        var div = t.parent().find('#passwordChecker');
        
        switch(score) {
            case 0:
            case 1:
                div.css('color','red');
                break;
            case 2:
            case 3:
                div.css('color','orange');
                break;
            case 4:
            case 5:
                div.css('color','green');
                break;
        }
        div.html(desc[score]).show();
        if (val.length < 6) {
            div.css('color','red').html('암호문은 적어도 6글자 이상이어야 합니다');
        }
    });
  //하루에 한번 보안 수칙 팝업 보이게 함
    if(getCookie('securityWarning_'+OC.currentUser)!=='done') {
        openPop(OC.filePath('nexonotp', '', 'security_popup.php'),'보안 수칙 안내',655,485);
    }
});