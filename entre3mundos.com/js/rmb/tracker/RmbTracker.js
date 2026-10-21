var RmbTracker = function()
{
this.scripts = [];
this.index = 0;
};
RmbTracker.prototype.add = function(script)
{
this.scripts.push(script)
};
RmbTracker.prototype.execute = function()
{
if (this.scripts.length == 0)
{
return;
}
this.index = 0;
var ctx = this;
var _handler = function()
{
//alert("Prueba tracker");
ctx._execute.apply(ctx, arguments);
};
var oldLoad = window.onload;
window.onload = function(e)
{
if (typeof oldLoad == "function") {
oldLoad(e);
}
ctx._execute.apply(ctx, arguments);
}
};
RmbTracker.prototype._execute = function()
{
if (this.index < this.scripts.length)
{
var script = this.scripts[this.index];
this.index++;
if (typeof script == "function")
{
//console.log("Funcion");
script();
this._execute();
}
else if ((typeof script == "object") && ("url" in script))
{
this._getScript(script);
}
}
else
{
this.index = -1;
}
};
RmbTracker.prototype._getScript = function(script)
{
var scriptNode = document.createElement("script");
scriptNode.type = "text/javascript";
scriptNode.src = script.url;
if ("id" in script)
{
scriptNode.id = script.id;
}
var ctx = this;
var _handler = function()
{
//console.log("Cargado: " + scriptNode.src)
scriptNode.onloadDone = true;
ctx._execute.apply(ctx, arguments);
};
scriptNode.onload = function()
{
if (!scriptNode.onloadDone)
{
_handler();
}
};
scriptNode.onreadystatechange = function()
{
if (("loaded" === scriptNode.readyState || "complete" === scriptNode.readyState) && !scriptNode.onloadDone)
{
_handler();
}
};
document.body.appendChild(scriptNode);
};