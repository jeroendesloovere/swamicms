// Jeroen Desloovere
// Backend startup
(function($){
	// Navigation
	$('.nav-item-arrow').mouseover(function(){
		$(this).addClass('hover');
		$('ul', this).show();
	});
	$('.nav-item-arrow').mouseout(function(){
		$(this).removeClass('hover');
		$('ul', this).hide();
	});
	
	// Notes
	$('#note').delay(2500).fadeOut(200);
	$('#note').live('click', function(){$(this).hide();});
	
	// Reorder tables
    $(".table [data-reorder]").each(function()
    {
    	// Add reorder item to table rows
    	$('tr', this).prepend('<td class="dragger"><div class="move"></div><span></span></td>');
    
    	// Add table drag'ndrop
    	var url = $(this).attr('data-reorder');
    	$(this).tableDnD({
			dragHandle: "dragger",
			onDrop: function(table, row){
				$.post(url, {items: $.tableDnD.serialize()}, function(data) {
					if(data.success) $.notice('success',data.msg);
					else if(data.error) $.notice('error',data.msg);
				}, "json").error(function() { $.notice('error',"error"); });
			}	
		});
    });
})(this.jQuery);






















