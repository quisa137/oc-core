$(function(){
    var list = $('#settings');
    var settings = function(){}
    settings.add =function() {
            ['<tr>',
                '<td></td>',
                '<td></td>',
                '<td><a href="#" class="modify">',t('sbotp','Modify'),'</a> <a href="#" class="delete">',t('sbotp','Delete'),'</a></td>',
            '</tr>'].join("");
    };
    settings.remove = function() {
        if(confirm('Do you want really delete?')) {
            var caller = $(this);
            var idx = caller.parents('tr:first').data('idx');
            $.post(OC.filePath('sbotp', 'ajax', 'admin.php'),{'deleteIdx':idx}, function(res){
                if(res.data=='success') {
                    caller.remove();
                }
            });
        }
    }
    settings.reset =function() {

    }
});