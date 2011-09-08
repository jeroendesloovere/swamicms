// usage: log('inside coolFunc', this, arguments);
window.log = function(){
  log.history = log.history || [];   // store logs to an array for reference
  log.history.push(arguments);
  arguments.callee = arguments.callee.caller;  
  if(this.console) console.log( Array.prototype.slice.call(arguments) );
};
// make it safe to use console.log always
(function(b){function c(){}for(var d="assert,count,debug,dir,dirxml,error,exception,group,groupCollapsed,groupEnd,info,log,markTimeline,profile,profileEnd,time,timeEnd,trace,warn".split(","),a;a=d.pop();)b[a]=b[a]||c})(window.console=window.console||{});

// jQuery cookie
jQuery.cookie=function(name,value,options){if(typeof value!='undefined'){options=options||{};if(value===null){value='';options=$.extend({},options);options.expires=-1;}var expires='';if(options.expires&&(typeof options.expires=='number'||options.expires.toUTCString)){var date;if(typeof options.expires=='number'){date=new Date();date.setTime(date.getTime()+(options.expires*24*60*60*1000));}else{date=options.expires;}expires='; expires='+date.toUTCString();}var path=options.path?'; path='+(options.path):'';var domain=options.domain?'; domain='+(options.domain):'';var secure=options.secure?'; secure':'';document.cookie=[name,'=',encodeURIComponent(value),expires,path,domain,secure].join('');}else{var cookieValue=null;if(document.cookie&&document.cookie!=''){var cookies=document.cookie.split(';');for(var i=0;i<cookies.length;i++){var cookie=jQuery.trim(cookies[i]);if(cookie.substring(0,name.length+1)==(name+'=')){cookieValue=decodeURIComponent(cookie.substring(name.length+1));break;}}}return cookieValue;}};

// TODO: stop animation on new notice
// Notice handler
jQuery.notice=function(type,message){
	var note = $('#note');
	if(note.length==0){ note = $('<p id="note" class="'+type+'">'+message+'</p>'); $('body').prepend(note);}
	else note.stop(true,true);
	note.addClass(type).html(message).show().delay(2500).fadeOut(200);
};

// Default attribute toggler
jQuery.fn.toggleAttr = function(name, onValue, offValue, on)
{
	function set($element, on)
	{
		var value = on ? onValue : offValue;
		return value == null ?
			$element.removeAttr(name) :
			$element.attr(name,value);
	}
	return on !== undefined ?
		set(this,on):
		this.each(function(i, element)
		{
			var $element = $(element);
			set($element, $element.attr(name) !== onValue);	
		});
};
// Toggle Checkbox/Radiobutton (bool) checked/unchecked
jQuery.fn.toggleChecked = function(checked){ return this.toggleAttr('checked',false,true,checked); }

// Toggle Checkbox (bool) enable/disable
jQuery.fn.toggleEnable = function(enable){ return this.toggleAttr('disabled',false,true,enable); }

/**
 * TableDnD plug-in for JQuery, allows you to drag and drop table rows
 * You can set up various options to control how the system will work
 * Copyright (c) Denis Howlett <denish@isocra.com>
 * Licensed like jQuery, see http://docs.jquery.com/License.
 *
 * Configuration options:
 * 
 * onDragStyle
 *     This is the style that is assigned to the row during drag. There are limitations to the styles that can be
 *     associated with a row (such as you can't assign a border--well you can, but it won't be
 *     displayed). (So instead consider using onDragClass.) The CSS style to apply is specified as
 *     a map (as used in the jQuery css(...) function).
 * onDropStyle
 *     This is the style that is assigned to the row when it is dropped. As for onDragStyle, there are limitations
 *     to what you can do. Also this replaces the original style, so again consider using onDragClass which
 *     is simply added and then removed on drop.
 * onDragClass
 *     This class is added for the duration of the drag and then removed when the row is dropped. It is more
 *     flexible than using onDragStyle since it can be inherited by the row cells and other content. The default
 *     is class is tDnD_whileDrag. So to use the default, simply customise this CSS class in your
 *     stylesheet.
 * onDrop
 *     Pass a function that will be called when the row is dropped. The function takes 2 parameters: the table
 *     and the row that was dropped. You can work out the new order of the rows by using
 *     table.rows.
 * onDragStart
 *     Pass a function that will be called when the user starts dragging. The function takes 2 parameters: the
 *     table and the row which the user has started to drag.
 * onAllowDrop
 *     Pass a function that will be called as a row is over another row. If the function returns true, allow 
 *     dropping on that row, otherwise not. The function takes 2 parameters: the dragged row and the row under
 *     the cursor. It returns a boolean: true allows the drop, false doesn't allow it.
 * scrollAmount
 *     This is the number of pixels to scroll if the user moves the mouse cursor to the top or bottom of the
 *     window. The page should automatically scroll up or down as appropriate (tested in IE6, IE7, Safari, FF2,
 *     FF3 beta
 * dragHandle
 *     This is the name of a class that you assign to one or more cells in each row that is draggable. If you
 *     specify this class, then you are responsible for setting cursor: move in the CSS and only these cells
 *     will have the drag behaviour. If you do not specify a dragHandle, then you get the old behaviour where
 *     the whole row is draggable.
 * 
 * Other ways to control behaviour:
 *
 * Add class="nodrop" to any rows for which you don't want to allow dropping, and class="nodrag" to any rows
 * that you don't want to be draggable.
 *
 * Inside the onDrop method you can also call $.tableDnD.serialize() this returns a string of the form
 * <tableID>[]=<rowID1>&<tableID>[]=<rowID2> so that you can send this back to the server. The table must have
 * an ID as must all the rows.
 *
 * Other methods:
 *
 * $("...").tableDnDUpdate() 
 * Will update all the matching tables, that is it will reapply the mousedown method to the rows (or handle cells).
 * This is useful if you have updated the table rows using Ajax and you want to make the table draggable again.
 * The table maintains the original configuration (so you don't have to specify it again).
 *
 * $("...").tableDnDSerialize()
 * Will serialize and return the serialized string as above, but for each of the matching tables--so it can be
 * called from anywhere and isn't dependent on the currentTable being set up correctly before calling
 *
 * Known problems:
 * - Auto-scoll has some problems with IE7  (it scrolls even when it shouldn't), work-around: set scrollAmount to 0
 * 
 * Version 0.2: 2008-02-20 First public version
 * Version 0.3: 2008-02-07 Added onDragStart option
 *                         Made the scroll amount configurable (default is 5 as before)
 * Version 0.4: 2008-03-15 Changed the noDrag/noDrop attributes to nodrag/nodrop classes
 *                         Added onAllowDrop to control dropping
 *                         Fixed a bug which meant that you couldn't set the scroll amount in both directions
 *                         Added serialize method
 * Version 0.5: 2008-05-16 Changed so that if you specify a dragHandle class it doesn't make the whole row
 *                         draggable
 *                         Improved the serialize method to use a default (and settable) regular expression.
 *                         Added tableDnDupate() and tableDnDSerialize() to be called when you are outside the table
 */

jQuery.tableDnD={currentTable:null,dragObject:null,mouseOffset:null,oldY:0,build:function(options){this.each(function(){this.tableDnDConfig=jQuery.extend({onDragStyle:null,onDropStyle:null,onDragClass:"tDnD_whileDrag",onDrop:null,onDragStart:null,scrollAmount:5,serializeRegexp:/[^\-]*$/,serializeParamName:null,dragHandle:null},options||{});jQuery.tableDnD.makeDraggable(this);});jQuery(document).bind('mousemove',jQuery.tableDnD.mousemove).bind('mouseup',jQuery.tableDnD.mouseup);return this;},makeDraggable:function(table){var config=table.tableDnDConfig;if(table.tableDnDConfig.dragHandle){var cells=jQuery("td."+table.tableDnDConfig.dragHandle,table);cells.each(function(){jQuery(this).mousedown(function(ev){jQuery.tableDnD.dragObject=this.parentNode;jQuery.tableDnD.currentTable=table;jQuery.tableDnD.mouseOffset=jQuery.tableDnD.getMouseOffset(this,ev);if(config.onDragStart){config.onDragStart(table,this);}
return false;});})}else{var rows=jQuery("tr",table);rows.each(function(){var row=jQuery(this);if(!row.hasClass("nodrag")){row.mousedown(function(ev){if(ev.target.tagName=="TD"){jQuery.tableDnD.dragObject=this;jQuery.tableDnD.currentTable=table;jQuery.tableDnD.mouseOffset=jQuery.tableDnD.getMouseOffset(this,ev);if(config.onDragStart){config.onDragStart(table,this);}
return false;}}).css("cursor","move");}});}},updateTables:function(){this.each(function(){if(this.tableDnDConfig){jQuery.tableDnD.makeDraggable(this);}})},mouseCoords:function(ev){if(ev.pageX||ev.pageY){return{x:ev.pageX,y:ev.pageY};}
return{x:ev.clientX+document.body.scrollLeft-document.body.clientLeft,y:ev.clientY+document.body.scrollTop-document.body.clientTop};},getMouseOffset:function(target,ev){ev=ev||window.event;var docPos=this.getPosition(target);var mousePos=this.mouseCoords(ev);return{x:mousePos.x-docPos.x,y:mousePos.y-docPos.y};},getPosition:function(e){var left=0;var top=0;if(e.offsetHeight==0){e=e.firstChild;}
while(e.offsetParent){left+=e.offsetLeft;top+=e.offsetTop;e=e.offsetParent;}
left+=e.offsetLeft;top+=e.offsetTop;return{x:left,y:top};},mousemove:function(ev){if(jQuery.tableDnD.dragObject==null){return;}
var dragObj=jQuery(jQuery.tableDnD.dragObject);var config=jQuery.tableDnD.currentTable.tableDnDConfig;var mousePos=jQuery.tableDnD.mouseCoords(ev);var y=mousePos.y-jQuery.tableDnD.mouseOffset.y;var yOffset=window.pageYOffset;if(document.all){if(typeof document.compatMode!='undefined'&&document.compatMode!='BackCompat'){yOffset=document.documentElement.scrollTop;}
else if(typeof document.body!='undefined'){yOffset=document.body.scrollTop;}}
if(mousePos.y-yOffset<config.scrollAmount){window.scrollBy(0,-config.scrollAmount);}else{var windowHeight=window.innerHeight?window.innerHeight:document.documentElement.clientHeight?document.documentElement.clientHeight:document.body.clientHeight;if(windowHeight-(mousePos.y-yOffset)<config.scrollAmount){window.scrollBy(0,config.scrollAmount);}}
if(y!=jQuery.tableDnD.oldY){var movingDown=y>jQuery.tableDnD.oldY;jQuery.tableDnD.oldY=y;if(config.onDragClass){dragObj.addClass(config.onDragClass);}else{dragObj.css(config.onDragStyle);}
var currentRow=jQuery.tableDnD.findDropTargetRow(dragObj,y);if(currentRow){if(movingDown&&jQuery.tableDnD.dragObject!=currentRow){jQuery.tableDnD.dragObject.parentNode.insertBefore(jQuery.tableDnD.dragObject,currentRow.nextSibling);}else if(!movingDown&&jQuery.tableDnD.dragObject!=currentRow){jQuery.tableDnD.dragObject.parentNode.insertBefore(jQuery.tableDnD.dragObject,currentRow);}}}
return false;},findDropTargetRow:function(draggedRow,y){var rows=jQuery.tableDnD.currentTable.rows;for(var i=0;i<rows.length;i++){var row=rows[i];var rowY=this.getPosition(row).y;var rowHeight=parseInt(row.offsetHeight)/2;if(row.offsetHeight==0){rowY=this.getPosition(row.firstChild).y;rowHeight=parseInt(row.firstChild.offsetHeight)/2;}
if((y>rowY-rowHeight)&&(y<(rowY+rowHeight))){if(row==draggedRow){return null;}
var config=jQuery.tableDnD.currentTable.tableDnDConfig;if(config.onAllowDrop){if(config.onAllowDrop(draggedRow,row)){return row;}else{return null;}}else{var nodrop=jQuery(row).hasClass("nodrop");if(!nodrop){return row;}else{return null;}}
return row;}}
return null;},mouseup:function(e){if(jQuery.tableDnD.currentTable&&jQuery.tableDnD.dragObject){var droppedRow=jQuery.tableDnD.dragObject;var config=jQuery.tableDnD.currentTable.tableDnDConfig;if(config.onDragClass){jQuery(droppedRow).removeClass(config.onDragClass);}else{jQuery(droppedRow).css(config.onDropStyle);}
jQuery.tableDnD.dragObject=null;if(config.onDrop){config.onDrop(jQuery.tableDnD.currentTable,droppedRow);}
jQuery.tableDnD.currentTable=null;}},serialize:function(){if(jQuery.tableDnD.currentTable){return jQuery.tableDnD.serializeTable(jQuery.tableDnD.currentTable);}else{return"Error: No Table id set, you need to set an id on your table and every row";}},serializeTable:function(table){var result="";var tableId=table.id;var rows=table.rows;for(var i=0;i<rows.length;i++){if(result.length>0)result+="&";var rowId=rows[i].id;if(rowId&&rowId&&table.tableDnDConfig&&table.tableDnDConfig.serializeRegexp){rowId=rowId.match(table.tableDnDConfig.serializeRegexp)[0];}
result+=tableId+'[]='+rowId;}
return result;},serializeTables:function(){var result="";this.each(function(){result+=jQuery.tableDnD.serializeTable(this);});return result;}}
jQuery.fn.extend({tableDnD:jQuery.tableDnD.build,tableDnDUpdate:jQuery.tableDnD.updateTables,tableDnDSerialize:jQuery.tableDnD.serializeTables});