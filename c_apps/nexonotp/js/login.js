$(function(){
	var url = document.URL;
	url = url.substring(0, url.lastIndexOf("/"));
	
	var loginFrm = $('#password').parent();
	loginFrm.removeClass("infield groupbottom");
	loginFrm.addClass("infield groupmiddle");
	$('#password').attr( "autocomplete", "on" );
	loginFrm.after(
	    ['<p class="infield groupbottom">',
	    '<input id="otpNumber" type="password" placeholder="OTP Numbers" value="" name="otpNumber" required maxlength="8"' , ' original-title="" autocomplete="off">',
		'<label class="infield" for="otpPassword" style="opacity: 1;">One Time Password</label>',
		'<img id="password-icon" class="svg" alt="" src="'+url+'/core/img/actions/password.svg">',
		'</p>'].join("")
	);
	
	var sheet = document.styleSheets[0];
	sheet.insertRule('#otpNumber {padding-left: 36px !important;width: 223px !important;}', sheet.cssRules.length);
	sheet.insertRule(
		['#otpNumber+label+img {',
			'position:absolute; left:1.25em; top:1.1em;',
			'-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=30)"; filter:alpha(opacity=30); opacity:.3;',
		'}'].join("")
	, sheet.cssRules.length);
});