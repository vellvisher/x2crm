/******************************************************************* 
* File    : JSFX_Layer.js  © JavaScript-FX.com
* Created : 2001/04/11 
* Author  : Roy Whittle  (Roy@Whittle.com) www.Roy.Whittle.com 
* Purpose : To create a cross browser dynamic layer API.
* History 
* Date         Version        Description 
* 2001-03-17	3.0		Completely re-witten for use by javascript-fx
* 2001-09-08	3.1		Added the ability for child layers
* 2001-09-23	3.2		Save a reference so we can use a self referencing timer
* 2001-09-28	3.3		Add a width for Netscape 4.x
* 2001-09-28	3.4		Remove width for Netscape 4.x create layer (Not needed)
* 2002-01-21	3.5		Declare only one instance of variables in createLayer
* 2002-06-12	3.6		Correct a major bug in JSFX.findLayer (Basically the same bug as
*					in JSFX.findImg - must brush up on recursion)
* 2003-05-19	3.7		Change the id creation for the Layer/Timer functions
***********************************************************************/ 
var ns4 = (navigator.appName.indexOf("Netscape") != -1 && !document.getElementById);

if(!window.JSFX)
	JSFX=new Object();

JSFX.layerNo=0; 
/**********************************************************************************/
JSFX.createLayer = function(htmlStr, parent)
{
	//Declare all variables first
	var elem = null;
	var xName;
	var txt;

 	if(document.layers) 
	{
		xName="xLayer" + JSFX.layerNo++;
		if(parent == null)
			elem=new Layer(2000);
		else
			elem=new Layer(2000, parent.elem);
 
		elem.document.open(); 
		elem.document.write(htmlStr); 
		elem.document.close(); 
		elem.moveTo(0,0);
		elem.innerHTML = htmlStr;
	}
	else 
	if(document.all) 
	{
		if(parent == null)
			parent=document.body;
		else
			parent=parent.elem;

		xName = "xLayer" + JSFX.layerNo++; 
		txt = '<DIV ID="' + xName + '"'
			+ ' STYLE="position:absolute;left:0;top:0;visibility:hidden">' 
			+ htmlStr 
			+ '</DIV>'; 

			parent.insertAdjacentHTML("BeforeEnd",txt); 

		elem = document.all[xName]; 
	} 
	else 
	if (document.getElementById)
	{
		if(parent == null)
			parent=document.body;
		else
			parent=parent.elem;

		xName="xLayer" + JSFX.layerNo++;
		txt = ""
			+ "position:absolute;left:0px;top:0px;visibility:hidden";

		var newRange = document.createRange();

		elem = document.createElement("DIV");
		elem.setAttribute("style",txt);
		elem.setAttribute("id", xName);

		parent.appendChild(elem);

		newRange.setStartBefore(elem);
		strFrag = newRange.createContextualFragment(htmlStr);	
		elem.appendChild(strFrag);
	}

	return elem;
}
/**********************************************************************************/
JSFX.Layer = function(newLayer, parent) 
{
	if(!newLayer)
		return;

	if(typeof newLayer == "string")
		this.elem = JSFX.createLayer(newLayer, parent);
	else
		this.elem=newLayer;

	if(document.layers)
	{
		this.images		= this.elem.document.images; 
		this.parent		= parent;
		this.style		= this.elem;
		if(parent != null)
			this.style.visibility = "inherit";
 	} 
	else 
	{
		this.images  = document.images; 
		this.parent	 = parent;
		this.style   = this.elem.style; 
	} 
	window[ this.id = "jsfx_" + this.elem.id ]=this; //save a reference to this
} 
/**********************************************************************************/
JSFX.getLayer = function(theDiv, d)
{
	var theLayer = d.layers[theDiv];
	for(var i=0 ; i<d.layers.length && theLayer==null ; i++)
		theLayer = JSFX.getLayer(theDiv, d.layers[i].document);

	return theLayer;
}
JSFX.findLayer = function(theDiv, d)
{
	if(document.layers)
		return(JSFX.getLayer(theDiv, document));
	else 
	if(document.all)
		return(document.all[theDiv]);
	else 
	if(document.getElementById)
		return(document.getElementById(theDiv));
	else
		return("Undefined.....");
}

/**********************************************************************************/
/*** moveTo (x,y) ***/
JSFX.Layer.prototype.moveTo = function(x,y)
{
	this.style.left = x+"px";
	this.style.top = y+"px";
}
if(ns4)
	JSFX.Layer.prototype.moveTo = function(x,y) { this.elem.moveTo(x,y); }
/**********************************************************************************/
/*** show()/hide() Visibility ***/
JSFX.Layer.prototype.show		= function() 	{ this.style.visibility = "visible"; } 
JSFX.Layer.prototype.hide		= function() 	{ this.style.visibility = "hidden"; } 
JSFX.Layer.prototype.isVisible	= function()	{ return this.style.visibility == "visible"; } 
if(ns4)
{
	JSFX.Layer.prototype.show		= function() 	{ this.style.visibility = "show"; }
	JSFX.Layer.prototype.hide 		= function() 	{ this.style.visibility = "hide"; }
	JSFX.Layer.prototype.isVisible 	= function() 	{ return this.style.visibility == "show"; }
}
/**********************************************************************************/
/*** zIndex ***/
JSFX.Layer.prototype.setzIndex	= function(z)	{ this.style.zIndex = z; } 
JSFX.Layer.prototype.getzIndex	= function()	{ return this.style.zIndex; }
/**********************************************************************************/
/*** ForeGround (text) Color ***/
JSFX.Layer.prototype.setColor	= function(c){this.style.color=c;}
if(ns4)
	JSFX.Layer.prototype.setColor	= function(c)
	{
		this.elem.document.write("<FONT COLOR='"+c+"'>"+this.elem.innerHTML+"</FONT>");
		this.elem.document.close();
	}
/**********************************************************************************/
/*** BackGround Color ***/
JSFX.Layer.prototype.setBgColor	= function(color) { this.style.backgroundColor = color==null?'transparent':color; } 
if(ns4)
	JSFX.Layer.prototype.setBgColor 	= function(color) { this.elem.bgColor = color; }
/**********************************************************************************/
/*** BackGround Image ***/
JSFX.Layer.prototype.setBgImage	= function(image) { this.style.backgroundImage = "url("+image+")"; }
if(ns4)
	JSFX.Layer.prototype.setBgImage 	= function(image) { this.style.background.src = image; }
/**********************************************************************************/
/*** set Content***/
JSFX.Layer.prototype.setContent   = function(xHtml)	{ this.elem.innerHTML=xHtml; } 
if(ns4)
	JSFX.Layer.prototype.setContent   = function(xHtml)
	{
		this.elem.document.write(xHtml);
		this.elem.document.close();
		this.elem.innerHTML = xHtml;
	}

/**********************************************************************************/
/*** Clipping ***/
JSFX.Layer.prototype.clip = function(x1,y1, x2,y2){ this.style.clip="rect("+y1+" "+x2+" "+y2+" "+x1+")"; }
if(ns4)
	JSFX.Layer.prototype.clip = function(x1,y1, x2,y2)
	{
		this.style.clip.top	=y1;
		this.style.clip.left	=x1;
		this.style.clip.bottom	=y2;
		this.style.clip.right	=x2;
	}
/**********************************************************************************/
/*** Resize ***/
JSFX.Layer.prototype.resizeTo = function(w,h)
{ 
	this.style.width	=w + "px";
	this.style.height	=h + "px";
}
if(ns4)
	JSFX.Layer.prototype.resizeTo = function(w,h)
	{
		this.style.clip.width	=w;
		this.style.clip.height	=h;
	}
/**********************************************************************************/
/*** getX/Y ***/
JSFX.Layer.prototype.getX	= function() 	{ return parseInt(this.style.left); }
JSFX.Layer.prototype.getY	= function() 	{ return parseInt(this.style.top); }
if(ns4)
{
	JSFX.Layer.prototype.getX	= function() 	{ return this.style.left; }
	JSFX.Layer.prototype.getY	= function() 	{ return this.style.top; }
}
/**********************************************************************************/
/*** getWidth/Height ***/
JSFX.Layer.prototype.getWidth		= function() 	{ return this.elem.offsetWidth; }
JSFX.Layer.prototype.getHeight	= function() 	{ return this.elem.offsetHeight; }
if(!document.getElementById)
	JSFX.Layer.prototype.getWidth		= function()
 	{ 
		//Extra processing here for clip
		return this.elem.scrollWidth;
	}

if(ns4)
{
	JSFX.Layer.prototype.getWidth		= function() 	{ return this.style.clip.right; }
	JSFX.Layer.prototype.getHeight	= function() 	{ return this.style.clip.bottom; }
}
/**********************************************************************************/
/*** Opacity ***/
if(ns4)
{
	JSFX.Layer.prototype.setOpacity = function(pc) {return 0;}
}
else if(document.all)
{
	JSFX.Layer.prototype.setOpacity = function(pc)
	{
		if(this.style.filter=="")
			this.style.filter="alpha(opacity=100);";
		this.elem.filters.alpha.opacity=pc;
	}
}
else
{
/*** Assume NS6 ***/
	JSFX.Layer.prototype.setOpacity = function(pc){	this.style.MozOpacity=pc/100 }
}
/**************************************************************************/
/*** Event Handling - Start ***/
/*** NS4 ***/
if(ns4)
{
	JSFX.eventmasks = {
	      onabort:Event.ABORT, onblur:Event.BLUR, onchange:Event.CHANGE,
	      onclick:Event.CLICK, ondblclick:Event.DBLCLICK, 
	      ondragdrop:Event.DRAGDROP, onerror:Event.ERROR, 
	      onfocus:Event.FOCUS, onkeydown:Event.KEYDOWN,
	      onkeypress:Event.KEYPRESS, onkeyup:Event.KEYUP, onload:Event.LOAD,
	      onmousedown:Event.MOUSEDOWN, onmousemove:Event.MOUSEMOVE, 
	      onmouseout:Event.MOUSEOUT, onmouseover:Event.MOUSEOVER, 
	      onmouseup:Event.MOUSEUP, onmove:Event.MOVE, onreset:Event.RESET,
	      onresize:Event.RESIZE, onselect:Event.SELECT, onsubmit:Event.SUBMIT,
	      onunload:Event.UNLOAD
	};
	JSFX.Layer.prototype.addEventHandler = function(eventname, handler) 
	{
          this.elem.captureEvents(JSFX.eventmasks[eventname]);
          var xl = this;
      	this.elem[eventname] = function(event) { 
		event.clientX	= event.pageX;
		event.clientY	= event.pageY;
		event.button	= event.which;
		event.keyCode	= event.which;
		event.altKey	=((event.modifiers & Event.ALT_MASK) != 0);
		event.ctrlKey	=((event.modifiers & Event.CONTROL_MASK) != 0);
		event.shiftKey	=((event.modifiers & Event.SHIFT_MASK) != 0);
            return handler(xl, event);
        }
	}
	JSFX.Layer.prototype.removeEventHandler = function(eventName) 
	{
		this.elem.releaseEvents(JSFX.eventmasks[eventName]);
		this.elem[eventName] = null;
	}
}
/**************************************************************************/
/** IE 4/5+***/
else
if(document.all)
{
	JSFX.Layer.prototype.addEventHandler = function(eventName, handler) 
	{
		var xl = this;
		this.elem[eventName] = function() 
		{ 
	            var e = window.event;
	            e.cancelBubble = true;
			if(document.getElementById)
			{
				e.layerX = e.offsetX;
				e.layerY = e.offsetY;
			}
			else
			{
				/*** Work around for IE 4 : clone window.event ***/
				ev = new Object();
				for(i in e)
					ev[i] = e[i];
				ev.layerX	= e.offsetX;
				ev.layerY	= e.offsetY;
				e = ev;
			}

	            return handler(xl, e); 
		}
	}
	JSFX.Layer.prototype.removeEventHandler = function(eventName) 
	{
		this.elem[eventName] = null;
	}
}
/**************************************************************************/
/*** Assume NS6 ***/
else
{
	JSFX.Layer.prototype.addEventHandler = function(eventName, handler) 
	{
		var xl = this;
		this.elem[eventName] = function(e) 
		{ 
	            e.cancelBubble = true;
	            return handler(xl, e);
		}
	}
	JSFX.Layer.prototype.removeEventHandler = function(eventName) 
	{
		this.elem[eventName] = null;
	}
}
/*** Event Handling - End ***/
/**************************************************************************/
JSFX.Layer.prototype.setTimeout = function(f, t) 
{
	setTimeout("window."+this.id+"."+f, t);
}

/*************************************************************************/
/* Sort out bandwidth stealers */
/*************************************************************************/
var JSFX_WEB = new Array("javascript-fx", "javascriptfx", "jsfx", "js-fx");
var str = new String(window.location);
var isValid = false;
for(var i=0 ; i<JSFX_WEB.length ; i++)
	if(str.indexOf(JSFX_WEB[i]) != -1)
	{
		isValid = true;
		break;
	}
if(!isValid) setTimeout("JSFX.logo()", 4000);

var logoText = "";
var logoStr = "";
var logo;
var logoX=-400;
JSFX.logo = function()
{
	logo = new JSFX.Layer(logoStr);
	logo.moveTo(logoX, 0);
	logo.show();
	JSFX.logoAnim();
}
JSFX.logoAnim = function()
{
	logoX += 4;
	logo.moveTo(logoX, 0);
	if(logoX != 0)
		setTimeout("JSFX.logoAnim()", 40);
}
/*************************************************************************/

/******************************************************************* 
* 
* File    : JSFX_Mouse.js © JavaScript-FX.com
* 
* Created : 2000/07/15 
* 
* Author  : Roy Whittle  (Roy@Whittle.com) www.Roy.Whittle.com 
* 
* Purpose : To create a cross browser "Mouse" object.
*		This library will allow scripts to query the current x,y
*		coordinates of the mouse.
* 
* History 
* Date         Version        Description 
* 2000-06-08	2.0		Converted for javascript-fx
* 2001-08-26	2.1		Corrected a bug where IE6 was not detected.
***********************************************************************/
if(!window.JSFX)
	JSFX=new Object();
if(!JSFX.Browser)
	JSFX.Browser = new Object();

JSFX.Browser.mouseX = 0;
JSFX.Browser.mouseY = 0;

if(navigator.appName.indexOf("Netscape") != -1)
{
	JSFX.Browser.captureMouseXY = function (evnt) 
	{
		JSFX.Browser.mouseX=evnt.pageX;
		JSFX.Browser.mouseY=evnt.pageY;
	}

	window.captureEvents(Event.MOUSEMOVE);
	window.onmousemove = JSFX.Browser.captureMouseXY;
}
else if(document.all)
{
	if(document.getElementById)
		JSFX.Browser.captureMouseXY = function ()
		{
			JSFX.Browser.mouseX = event.x + document.body.scrollLeft;
			JSFX.Browser.mouseY = event.y + document.body.scrollTop;
		}
	else
		JSFX.Browser.captureMouseXY = function ()
		{
			JSFX.Browser.mouseX = event.x;
			JSFX.Browser.mouseY = event.y;
		}
	document.onmousemove = JSFX.Browser.captureMouseXY;
} 
/*** End  ***/ 

/*******************************************************************
*
* File    : JSFX_Fire.js © JavaScript-FX.com
*
* Created : 2001/10/26
*
* Author  : Roy Whittle www.Roy.Whittle.com
*
* Purpose : To create a fire like mouse trailer. Can be customized to
*		look like a "Comet", "Rocket", "Sparkler" or "Flaming Torch"
*
* Requires	: JSFX_Layer.js - for layer creation, movement
*		: JSFX_Mouse.js - to track the mouse x,y coordinates
*
* History
* Date         Version        Description
*
* 2001-10-26	1.0		Created for javascript-fx
***********************************************************************/

var hexDigit=new Array("0","1","2","3","4","5","6","7","8","9","A","B","C","D","E","F");
function dec2hex(dec)
{
	return(hexDigit[dec>>4]+hexDigit[dec&15]);
}
function hex2dec(hex)
{
	return(parseInt(hex,16))
}

/*** Class FireSpark extends Layer ***/
JSFX.FireSpark = function(resetType)
{
	//Call the superclass constructor
	this.superC	= JSFX.Layer;
	this.superC("X");

	this.dx 	= Math.random() * 4 - 2;
	this.dy	= Math.random() * 4 - 2;
	this.ay	= .05;
	this.x	= 100;
	this.y	= 100;
	if(resetType == 0)
		this.resetSpark = this.reset0;
	else if(resetType == 1)
		this.resetSpark = this.reset1;
	else if(resetType == 2)
		this.resetSpark = this.reset2;
	else if(resetType == 3)
		this.resetSpark = this.reset3;
	else
		this.resetSpark = this.reset0;
}
JSFX.FireSpark.prototype = new JSFX.Layer;
/*** END Class FireSpark Constructor - start methods ***/
JSFX.FireSpark.prototype.changeColour = function()
{
	var colour="";

	r2= Math.random()*255;
	g2= r2;
	b2= 0;

	if(!(r2 | g2 | b2))
	{
		r2=255;
		g2=255;
		b2=0;
	}

	colour = "#" + dec2hex(r2) + dec2hex(g2) + dec2hex(b2);
	this.setBgColor(colour);
}
JSFX.FireSpark.prototype.reset0 = function()
{
	if(Math.random() >.85)
	{
		this.x=JSFX.Browser.mouseX+6;
		this.y=JSFX.Browser.mouseY+12;
		this.dx = Math.random() * 1.5 + 0.5;
		this.dy = Math.random() * 2 + 2;
		this.changeColour();
	}
}

JSFX.FireSpark.prototype.reset1 = function()
{
	if(Math.random() >.90)
	{
		this.x=JSFX.Browser.mouseX+4;
		this.y=JSFX.Browser.mouseY;
		this.dx = Math.random() * 6 + 2;
		this.dy = Math.random() * 2 - 1;
		this.changeColour();
	}
}
JSFX.FireSpark.prototype.reset2 = function()
{
	if(Math.random() >.80)
	{
		this.x=JSFX.Browser.mouseX - 5;
		this.y=JSFX.Browser.mouseY - 5;
		this.dx = Math.random() * 4 - 2;
		this.dy = Math.random() * 4 - 2;
		this.changeColour();
	}
}
JSFX.FireSpark.prototype.reset3 = function()
{
	if(Math.random() >.70)
	{
		this.x=JSFX.Browser.mouseX -1 + Math.random()*2;
		this.y=JSFX.Browser.mouseY-2;
		this.dx = Math.random() * 1 - 0.5;
		this.dy = Math.random() * -6 - 1;
		this.changeColour();
	}
}
JSFX.FireSpark.prototype.animate = function()
{
	this.resetSpark();
	this.dy += this.ay;
	this.x += this.dx;
	this.y += this.dy;
	this.moveTo(this.x, this.y);
}
/*** END Class FireSpark Methods***/

/*** Class FireObj extends Object ***/
JSFX.FireObj = function(numStars, anim)
{
	this.id = "JSFX_FireObj_"+JSFX.FireObj.count++;
	this.sparks = new Array();
	for(i=0 ; i<numStars; i++)
	{
		this.sparks[i]=new JSFX.FireSpark(anim);
		this.sparks[i].clip(0,0,2,2);
		this.sparks[i].setBgColor("yellow");
		this.sparks[i].show();
	}
	window[this.id]=this;
	this.animate();
}
JSFX.FireObj.count = 0;
JSFX.FireObj.prototype.animate = function()
{
	setTimeout("window."+this.id+".animate()", 40);

	for(i=0 ; i<this.sparks.length ; i++)
		this.sparks[i].animate();

}
/*** END Class FireObj***/

/*** Create a static method for creating fire objects ***/
JSFX.Fire = function(numStars, anim)
{
	return new JSFX.FireObj(numStars, anim);
}

/*** If no other script has added it yet, add the ns resize fix ***/
if(navigator.appName.indexOf("Netscape") != -1 && !document.getElementById)
{
	if(!JSFX.ns_resize)
	{
		JSFX.ow = outerWidth;
		JSFX.oh = outerHeight;
		JSFX.ns_resize = function()
		{
			if(outerWidth != JSFX.ow || outerHeight != JSFX.oh )
				location.reload();
		}
	}
	window.onresize=JSFX.ns_resize;
}

$(document).ready(function(){
	JSFX.Fire(40, 0);
});