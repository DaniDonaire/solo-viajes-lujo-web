}
return _11;
}
;
function getCookie(_14) {
if (document.cookie.length > 0) {
c_start = document.cookie.indexOf(_14 + "=");
if (c_start != -1) {
c_start = c_start + _14.length + 1;
c_end = document.cookie.indexOf(";", c_start);
if (c_end == -1) {
c_end = document.cookie.length;
}
return unescape(document.cookie.substring(c_start, c_end));
}
}
return null;
}
;
function rmb_affiliates_gup(_15) {
_15 = _15.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
var _16 = "[\\?&]" + _15 + "=([^&#]*)";
var _17 = new RegExp(_16);
var _18 = _17.exec(window.location.href);
if (_18 == null) {
return null;
} else {
return _18[1];
}
}
;
function generateNotWhiteLabelJson(_19) {
var _1a = "{\"isWhiteLabel\":\"false\",\"affiliateId\":\"" + _19 + "\"}";
return _1a;
}
;
function generateWhiteLabelJson(_1b) {
if (_1b.indexOf("www.") == 0) {
_1b = _1b.substr(4);
}
var _1c = rmb.seo.WhiteLabelEntries.getWhiteLabelEntry(_1b);
if (_1c != null || _1c != undefined) {
ocultar();
} else {
_1c = generateNotWhiteLabelJson(_1b);
}
return _1c;
}
;
_1.getWhiteLabelData = function() {
return _whiteLabelData;
};
function ocultar() {
var _1d = document.createElement("style");
_1d.type = "text/css";
codigo = "#header{display: none;}#footer{display: none;}";
if (_1d.styleSheet) {
_1d.styleSheet.cssText = codigo;
} else {
_1d.appendChild(document.createTextNode(codigo));
}
document.getElementsByTagName("head")[0].appendChild(_1d);
}
;
checkCookie();
})();