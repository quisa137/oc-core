var openPop = function (link, name, width, height, left, top, optStr) {
    //left나 top 이 없으면 기본적으로 가운데로 띄워지게 하는 구문
    var winl = (!left) ? ((screen.width - width) / 2) : left;
    var wint = (!top) ? ((screen.height - height) / 2) : top;
    var defOpt = 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=no,copyhistory=no';
    optStr = (!optStr) ? defOpt : optStr;
    if(navigator.userAgent.indexOf('MSIE 9')>0) {
        name = null;
    }
    var popObj = (window.open(link, name, optStr + ',width=' + width + ',height=' + height + ',left=' + winl + ',top=' + wint));
    if (!popObj) {
        alert("팝업차단을 해제해 주세요");
    }
    return popObj;
};

function getCookie(name) {
    var cname = name + "=";
    var dc = document.cookie;
    var val = "";
    if (dc.length > 0) {
        begin = dc.indexOf(cname);
        if (begin != -1) {
            begin += cname.length;
            end = dc.indexOf(";", begin);
            if (end == -1) end = dc.length;
            val += unescape(dc.substring(begin, end));
        }
    }
    return val;
}

function setCookie(name, value, expiredays) {
    var today = new Date();
    today.setDate(today.getDate() + expiredays);
    document.cookie = name + "=" + escape(value) + "; path=/; expires=" + today.toGMTString() + ";";
}