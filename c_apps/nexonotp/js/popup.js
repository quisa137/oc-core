$(function(){
    var currentUser = $('#currentUser').val();
    if(getCookie('securityWarning_'+currentUser)=='done') {
        self.close();
    }
    $('.notOpenUtil7days').click(function(e){
        var t = $(e.currentTarget);
        if(t.prop('checked')) {
            setCookie('securityWarning_'+currentUser,'done',7);
            self.close();
        }
    });
    $('.close').click(function(e){
        setCookie('securityWarning_'+currentUser,'done',1);
        self.close();
    });
});
/*
$(window).unload(function(e){
    if($('.notOpenUtil7days').prop('checked')){
        setCookie('securityWarning','done',7);
    }else{
        setCookie('securityWarning','done',1);
    }
});
*/