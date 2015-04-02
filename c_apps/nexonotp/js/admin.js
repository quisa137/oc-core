$(document).ready(function(jQuery){
    var list = $("#sbotp_ip_list"),
        section = $("#sbotp"),
        formVal = true,
        settings = function(){},
        ipValidation = function(str){
            var regex = /((^|\.)((25[0-5])|(2[0-4]\d)|(1\d\d)|([1-9]?\d))){4}$/gi;
            str = str.split('/');
            if($.type(str) === 'array' && str.length > 0) {
                var flag = true;
                if(str.length == 2){
                    //대역 지정
                    var num = parseInt(str[1]);
                    flag = 0 < num && num < 32;
                }
                return flag && regex.test(str[0]);
            }
        };
    settings.add = function(e) {
        list.append('<li><input type="text" name="internal_ip[]" value=""/><input type="button" name="sbotp_delete_row"  value="-"/></li>');
    };
    settings.remove = function(e) {
        if(confirm(t('sbotp', 'Do you really delete this row?'))) {
            $(this).parent().remove();
        }
    };
    settings.save = function(e) {
        var iplist = $('[name^=internal_ip]');
        var content = $('#sbotp [name=content]').val();
        var secureAlarm = $('#sbotp [name=secureAlarm]').prop('checked');

        var inputArr = [];
        for(var i=0;i<iplist.length;i++) {
            var input = $(iplist[i]);
            if(ipValidation(input.val())){
                inputArr.push(input.val());
            }
        }
        if(formVal) {
            $.post(
                OC.filePath('sbotp', 'ajax', 'admin.php'), 
                {
                    'ips':JSON.stringify(inputArr),
                    'content':content,
                    'secureAlarm':(secureAlarm?'1':'0')
                },
                settings.afterSave
            );
        }
    };
    settings.afterSave = function(e){
        if(e.status=='success'){
            var ips = e.data.ips;
            list.children().remove();
            for(var i=0;i<ips.length;i++) {
                list.append('<li><input type="text" name="internal_ip[]" value="'+ips[i]+'"/><input type="button" name="sbotp_delete_row"  value="-"/></li>');
            }
        }
    };
    settings.ipChanged = function(e) {
        var input = $(this);
        if(!ipValidation(input.val())) {
            formVal = false;
            input.css('background-color','pink');
        }else {
            formVal = true;
            input.css('background-color','#C0FF77');
        }
    }
    settings.ipToint = function(str) {
        var ipnumbers = str.split('.'), amount = 0, res = 0;
        for(var i =0,j=3;i < ipnumbers.length;i++,j--){
            amount = (j < 0)?1:Math.pow(256,j);
            res += parseInt(ipnumbers[i]) * amount;
        }
        return res;
    }

    section.on('click',"[name=sbotp_add_row]",settings.add);
    section.on('click',"#sbotp_save",settings.save);
    list.on('click',"[name=sbotp_delete_row]",settings.remove);
    list.on('change',"[name^=internal_ip]",settings.ipChanged);
    section.on('click','[name=secureAlarm]',function(e){
        if($(this).prop('checked')){
            $('#sbotp [name=content]').prop('disabled',false);
        }else{
            $('#sbotp [name=content]').prop('disabled',true);
        }
    });
});