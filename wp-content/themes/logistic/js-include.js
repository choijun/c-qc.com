//----- NOTE - if you use an apostrophe, it will need to be escaped like this: \' -----//
// Content variables
var mainTitle = 'Ищите специалистов в транспортной логистике?';
var contentLineOne = 'Компания Customs Quality Center - то что вам нужно!';
var contentLineTwo = 'Комплексное оформление и поставка грузов под ключ, позволять нам предоставлять минимальные стоимости и сжатые сроки.'; // Anything you want to highlight, wrap it in a <span></span> tag
var contentSmallPrint = 'Надежность,заслужившая доверие огромного множества наших клиентов. <a href="http://c-qc.com/" target="_blank">c-qc.com</a>'; // Links must be wrapped in and <a href=""></a> tag

// Image variables
var imageSteps = '/images/';
var imageLogo = '//2.png';


// Popup HTML
varHTML = '<style>html{font-family:sans-serif;line-height:1.15;-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%}body{margin:0}article,aside,footer,header,nav,section{display:block}h1{font-size:2em;margin:.67em 0}figcaption,figure,main{display:block}figure{margin:1em 40px}hr{box-sizing:content-box;height:0;overflow:visible}pre{font-family:monospace,monospace;font-size:1em}a{background-color:transparent;-webkit-text-decoration-skip:objects}a:active,a:hover{outline-width:0}abbr[title]{border-bottom:none;text-decoration:underline;text-decoration:underline dotted}b,strong{font-weight:inherit;font-weight:bolder}code,kbd,samp{font-family:monospace,monospace;font-size:1em}dfn{font-style:italic}mark{background-color:#ff0;color:#000}small{font-size:80%}sub,sup{font-size:75%;line-height:0;position:relative;vertical-align:baseline}sub{bottom:-.25em}sup{top:-.5em}audio,video{display:inline-block}audio:not([controls]){display:none;height:0}img{border-style:none}svg:not(:root){overflow:hidden}button,input,optgroup,select,textarea{font-family:sans-serif;font-size:100%;line-height:1.15;margin:0}button,input{overflow:visible}button,select{text-transform:none}button,html [type="button"],[type="reset"],[type="submit"]{-webkit-appearance:button}button::-moz-focus-inner,[type="button"]::-moz-focus-inner,[type="reset"]::-moz-focus-inner,[type="submit"]::-moz-focus-inner{border-style:none;padding:0}button:-moz-focusring,[type="button"]:-moz-focusring,[type="reset"]:-moz-focusring,[type="submit"]:-moz-focusring{outline:1px dotted ButtonText}fieldset{border:1px solid silver;margin:0 2px;padding:.35em .625em .75em}legend{box-sizing:border-box;color:inherit;display:table;max-width:100%;padding:0;white-space:normal}progress{display:inline-block;vertical-align:baseline}textarea{overflow:auto}[type="checkbox"],[type="radio"]{box-sizing:border-box;padding:0}[type="number"]::-webkit-inner-spin-button,[type="number"]::-webkit-outer-spin-button{height:auto}[type="search"]{-webkit-appearance:textfield;outline-offset:-2px}[type="search"]::-webkit-search-cancel-button,[type="search"]::-webkit-search-decoration{-webkit-appearance:none}::-webkit-file-upload-button{-webkit-appearance:button;font:inherit}details,menu{display:block}summary{display:list-item}canvas{display:inline-block}template{display:none}[hidden]{display:none}.herbalife-popup{position:fixed!important;top:0!important;right:0!important;bottom:0!important;left:0!important;z-index:999999!important;text-align:center!important;display:none;font-family:\'Helvetica\',\'Arial\',sans-serif!important;color:#6c6d70!important}.herbalife-bg{position:absolute!important;top:0!important;right:0!important;bottom:0!important;left:0!important;background:#000!important;opacity:0.9!important;z-index:999998!important}.herbalife-wrap{min-width:400px!important;height:auto!important;max-height:100%!important;position:absolute!important;top:50%!important;left:50%!important;z-index:999999!important;transform:translate(-50%,-50%)!important;margin:0 auto!important;font-family:\'Helvetica\',\'Arial\',sans-serif!important;color:#6c6d70!important;}.herbalife-content{position:relative!important;display:inline-block!important;padding:15px!important;background:#fff!important;font-family:\'Helvetica\',\'Arial\',sans-serif!important;color:#6c6d70!important}.herbalife-info{position:relative!important;float:left!important;padding:15px!important;border:3px solid #7ac142!important;font-family:\'Helvetica\',\'Arial\',sans-serif!important;color:#6c6d70!important}.herbalife-info h1{width:calc(100% - 2rem)!important;margin:0 0 15px 0!important;padding:0!important;font-size:24px!important;line-height:27px!important;font-weight:bold!important;font-family:\'Helvetica\',\'Arial\',sans-serif!important;color:#6c6d70!important}.herbalife-info .herbalife-close{position:absolute!important;top:5px!important;right:5px!important;background:#7ac142!important;border-radius:10px!important;font-size:12px!important;color:#fff!important;padding:0 8.7px!important;text-decoration:none!important;text-align:center!important;cursor:pointer!important;font-family:\'Helvetica\',\'Arial\',sans-serif!important;}.herbalife-info .herbalife-close:hover{background:#6c6d70!important;font-family:\'Helvetica\',\'Arial\',sans-serif!important;}.herbalife-info .herbalife-row{position:relative!important;float:left!important;font-family:\'Helvetica\',\'Arial\',sans-serif!important;color:#6c6d70!important}.herbalife-info .one-third{width:25%!important;position:relative!important;float:left!important;font-family:\'Helvetica\',\'Arial\',sans-serif!important;color:#6c6d70!important}.herbalife-info .one-third.border{width:calc(25% - 16px)!important;padding:0 15px 0 0!important;border-right:1px solid #7ac142!important;font-family:Helvetica,Arial\,sans-serif!important;color:#6c6d70!important}.herbalife-info .one-third img{max-width:100%!important;height:auto;font-family:\'Helvetica\',\'Arial\',sans-serif!important;color:#6c6d70!important}.herbalife-info .one-third img.f-right{float:right!important;margin:10px 0 0 0!important;font-family:\'Helvetica\',\'Arial\',sans-serif!important;color:#6c6d70!important}.herbalife-info .two-third{width:75%!important;position:relative!important;float:left!important;font-family:\'Helvetica\',\'Arial\',sans-serif!important;color:#6c6d70!important}.herbalife-info .two-third.border{width:calc(75% - 15px)!important;padding:0 0 0 15px!important;font-family:\'Helvetica\',\'Arial\',sans-serif!important;color:#6c6d70!important}.herbalife-info .two-third p{margin:0 0 10px 0!important;padding:0!important;font-size:16px!important;line-height:20px!important;text-align:left!important;font-family:\'Helvetica\',\'Arial\',sans-serif!important;color:#6c6d70!important}.herbalife-info .two-third p.copy{margin:15px 0 0 0!important;font-size:14px!important;line-height:13px!important;font-family:\'Helvetica\',\'Arial\',sans-serif!important;color:#6c6d70!important}.herbalife-info .two-third p span{font-family:\'Helvetica\',\'Arial\',sans-serif!important;color:#7ac142!important}.herbalife-info .two-third p a{font-weight:bold;text-decoration:none;font-family:\'Helvetica\',\'Arial\',sans-serif!important;color:#6c6d70!important}.herbalife-info .two-third p a:hover{text-decoration:underline!important}.clear{height:0px!important;line-height:0px!important;clear:both!important}@media screen and (max-width:767px){.herbalife-wrap{min-width:90%!important}.herbalife-info .one-third,.herbalife-info .two-third,.herbalife-info .one-third.border,.herbalife-info .two-third.border{width:100%!important;margin:0 0 10px 0!important;padding:0!important;border:0!important}.herbalife-info .one-third.border{text-align:center!important}.herbalife-info .two-third,.herbalife-info .two-third.border{margin:0!important}.herbalife-info .one-third{margin:0!important}.herbalife-info .one-third img.f-right{float:left!important;margin:5px 0 0 0!important}}@media screen and (min-width:768px){.herbalife-wrap{min-width:768px!important}}@media screen and (min-width:850px){.herbalife-wrap{min-width:850px!important}}</style><div class="herbalife-popup" id="wc_herba_popup"><div class="herbalife-bg">&nbsp;</div><div class="herbalife-wrap"><div class="herbalife-content"><div class="herbalife-info"><a class="herbalife-close" href="#" onclick="wcHidePopUp()">x</a><h1>'+ mainTitle +'</h1><div class="herbalife-row"><div class="one-third border"><img alt="Image" src="' + imageSteps + '"></div><div class="two-third border"><p>'+ contentLineOne +'</p><p>'+ contentLineTwo +'</p></div><div class="clear">&nbsp;</div></div><div class="herbalife-row"><div class="two-third"><p class="copy">'+ contentSmallPrint +'</p></div><div class="one-third"><img alt="Logo" class="f-right" src="' + imageLogo + '"></div><div class="clear">&nbsp;</div></div><div class="clear">&nbsp;</div></div></div></div></div>';

// Write HTML
document.getElementById('herbalifepopup').innerHTML = varHTML;

// Set a cookie
function wcSetCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+ d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

// Get a cookie
function wcGetCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i = 0; i <ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length,c.length);
        }
    }
    return "";
}

// Hide popup
function wcHidePopUp () {
    document.getElementById('wc_herba_popup').style.display = 'none'; // or 'block', or whatever.
}

var cookie_content = wcGetCookie('wc_popup_herba');


$(document).mouseleave(function(e){
    if (e.clientY < 0) {
    if (cookie_content != "shown") {
    document.getElementById('wc_herba_popup').style.display = 'block'; // or 'block', or whatever.
    wcSetCookie('wc_popup_herba', 'shown');
}
else{
wcHidePopUp();	
}
    }    
});