var transicion = function(inicio, fin, segundos, divId) {
var _this = this;
this.test = 0;
if (_this.intervalo)
clearInterval(_this.intervalo);
if (this.val && Math.abs(fin - _this.val) < 0.01)
return;
this.val = !this.val ? inicio < 1 ? inicio + .0001 : inicio : this.val;
set_opacity(this, this.val);
this.pasos = (fin - inicio) / 25;
this.pausa = segundos * 10;
this.intervalo = setInterval( function() {
if (_this.test > 299 || Math.abs(fin - _this.val) < 0.01) {
clearInterval(_this.intervalo);
/* if (show == 1) {
if (divId != 'desplieguePresupuesto') {
creaMatriz();
verScrollStep('left','60','5');
refreshButton();
//verScrollStep('rigth','60','5');
}
else {
deleteDivChildren('hotel');
deleteDivChildren('tabla');
}
} else {
creaMatriz();
verScrollStep('left','60','5');
refreshButton();
//verScrollStep('rigth','60','5');
}
*/
}
_this.test++;
_this.val = _this.val + _this.pasos;
if (_this.val <= .01) {
_this.style.display = 'none';
} else {
_this.style.display = 'block';
set_opacity(_this, _this.val, divId);
}
}, this.pausa);
}
function displayFloatingDiv(divId, width, height, left, top) {
if(width != 0)
{
document.getElementById(divId).style.width = width + "px";
}
if(height != 0)
{
document.getElementById(divId).style.height = height + "px";
}
if(left != 0)
{
document.getElementById(divId).style.left = left + "px";
}
if(top != 0)
{
document.getElementById(divId).style.top = top + "px";
}
document.getElementById(divId).className = "dimming";
shiftOpacityShow(divId);
}
function hiddenFloatingDiv(divId) {
shiftOpacityHide(divId);
}
function set_opacity(div, value, divId) {
div.style.opacity = value;
div.style.MozOpacity = value;
div.style.KhtmlOpacity = value;
div.style.filter = 'alpha(opacity=' + value * 300 + ')';
div.style.zoom = 1;
}
function shiftOpacityShow(divId) {
var obj = document.getElementById(divId);
transicion.call(obj, 0, 1, 1, divId);
}
function shiftOpacityHide(divId) {
var obj = document.getElementById(divId);
transicion.call(obj, 1, 0, 1, divId);
}