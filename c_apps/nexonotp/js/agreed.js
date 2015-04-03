/**
 * 
 */
$(function(){
    $.colorbox({
        opacity:0.4, 
        transition:"elastic", 
        speed:100, 
        width:"70%", 
        height:"75%", 
        href: OC.filePath('nexonotp', '', 'agree.php'),
        overlayClose : false,
        closeButton : false,
        escKey : false,
        open : true,
        onComplete : function(){
            $('#agree>.buttons>.agree').click(function(e){
                if(confirm('사용자 보안 수칙에 동의하십니까?')){
                    $.post(OC.filePath('nexonotp', 'ajax', 'agree.php'),function(e){
                        if(e.status=='success'){
                            $.colorbox.close();
                        }
                    });
                }
            });
        }
    });
});