function kanban_start_board(id, stageDropAction)
{
	$('#'+id).sortable({
		revert: 200,
		placeholder: 'kanban-stage-placeholder',
		forcePlaceholderSize: true,
		helper: function(event, element){
		    return $(element).clone().addClass('kanban-dragging');
		},
		start: function (e, ui) {
		    ui.item.show().addClass('kanban-ghost')
		},
		stop: function (e, ui) {
		    ui.item.show().removeClass('kanban-ghost')
		},
		update: function (e, ui) {
			var stageId   = $(ui.item).attr('stage_id');
			var positions = [];
			$(".kanban-stage").each( function(){
			    positions.push($(this).attr('stage_id'));
			});
    		var order = positions.join('&order[]=');
    		__adianti_load_page(stageDropAction+"&key="+stageId+"&id="+stageId+"&stage_id="+stageId+"&order[]="+order);
		},
		cursor:'move',
		tolerance:'pointer',
		cancel: '.kanban-stage-actions, .kanban-item, .kanban-shortcuts'
	});
}

function kanban_start_item(classItem, itemDropAction)
{
	$( '.'+classItem ).sortable({
		revert: 200,
		placeholder: 'kanban-item-placeholder',
		forcePlaceholderSize: true,
		connectWith: ".kanban-item-sortable",
		helper: function(event, element){
		    return $(element).clone().addClass('kanban-dragging');
		},
		start:  function (e, ui) {
		    ui.item.show().addClass('kanban-ghost')
		},
		stop:   function (e, ui) {
		    ui.item.show().removeClass('kanban-ghost')
		},
		update: function( event, ui ) {
			if (itemDropAction && this === ui.item.parent()[0]) {
				var itemId    = $(ui.item).attr('item_id');
				var stageId   = $(this).attr('stage_id')
				var positions = [];
				$("[stage_id="+stageId+"] .kanban-item").each(function(){
				    positions.push($(this).attr('item_id'));
				});
	    		// Remove possible "" value in array
				var item = "";
				var index = positions.indexOf(item);
				if (index !== -1) positions.splice(index, 1);
				
	    		var order = positions.join('&order[]=');
	    		__adianti_load_page(itemDropAction+"&key="+itemId+"&id="+itemId+"&stage_id="+stageId+"&order[]="+order);
    		}
		},
		cursor:'move',
		tolerance:'pointer',
		cancel: '.kanban-item-content, .kanban-item-actions'
    });
}

function kanban_start_load_more(id, loadMoreAction) 
{
    $.each( $('#' + id + ' .kanban-stage .kanban-item-sortable'), function(index, element) {
        var onscroll = true;

        element.onscroll = (e)=> {
        
            if(onscroll)
            {
                var stage_id = element.getAttribute("stage_id");
                var count    = $(".kanban-board [stage_id="+stage_id+"] .kanban-item").length;

                if (element.scrollTop + element.offsetHeight >= element.scrollHeight - 20) {
                    onscroll = false;
                    __adianti_load_page(loadMoreAction +"&static=1&key=" +stage_id+ "&offset=" +count, function(){onscroll = true;}); 
                    return false;
                }
            }
        }
    });
}

function kanban_start_minimap(id)
{
    var isDown = false;

    $('#'+id).closest(".kanban-board-wrapper").on('scroll', function(evt) {

        if(isDown)
        {
            return false;
        }
            
        var currX = $(this).scrollLeft();
        var postWidth = $(this).width();
        var scrollWidth = $('#'+id).width();
        var scrollPercent = (currX / (scrollWidth - postWidth)) * 100;
        
        var walk =( ($('#'+id+" #tkanban-layout-controller").width() - $('#'+id+" .tkanban-border-controler").width()) / 100 ) * scrollPercent;
        
        $('#'+id+" .tkanban-border-controler").css({left: walk })
    });
    
    $('#'+id + " .tkanban-border-controler").on('mousedown', (e) => {
        isDown = true;
    });
    
    $('#'+id+ " .tkanban-border-controler").on('mouseleave', () => {
        isDown = false;
    });
    
    $('#'+id+ " .tkanban-border-controler").on('mouseup', () => {
        isDown = false;
    });
    
    $('#'+id+ " .tkanban-border-controler").on('mousemove', (e) => {
        if(!isDown)
        {
            return;
        }
        
        e.preventDefault();
    
        const w = (document.querySelector('#'+id+" .tkanban-border-controler").offsetLeft - 3) / ($('#'+id+" #tkanban-layout-controller").width() - $('#'+id+" .tkanban-border-controler").width());
    
        const walk = (document.querySelector('#'+id+" .tkanban-border-controler").offsetLeft + (-3 + (6 * w)) ) * 10;

        $('#'+id).closest(".kanban-board-wrapper")[0].scroll({top: 0, left: walk, behavior: 'instant' })
    });
    
    $('#'+id+" .tkanban-border-controler").draggable({ axis: "x", cursor: "move", containment: "parent"});

    $(window).resize(function () {
        let width = (
            $('#'+id+" #tkanban-layout-controller").width() - 
            ($('#'+id+" .tkanban-border-controler").position().left + $('#'+id+" .tkanban-border-controler").width() - 5)
        );
        if(width < 0)
        {
            $('#'+id+" .tkanban-border-controler").css("left", $('#'+id+" .tkanban-border-controler").position().left + width);
        }
    
        tkanban_resize_border_controler(id);
    });  
    
    tkanban_resize_border_controler(id);
}
          
function tkanban_resize_border_controler(id)
{
    setTimeout(function() {
        var menu_size = ($('.sidebar').width()??0 + $('.master-menu-content').width()??0) / 10; 
        var margin_menu = parseFloat($('.sidebar').css('margin-left')??0) / 10;
        menu_size = menu_size + margin_menu;
        
        $('#'+id+" .tkanban-border-controler").width(
            `calc( 10vw - ${menu_size}px )`
        );
    }, 0);
}

function tkanban_add_item(id, stageId, item) {
	var itemKanban = $("[stage_id="+stageId+"] [item_id="+id+"]");

    if (itemKanban.length > 0)
	{
		itemKanban.replaceWith(base64_decode(item));
	}
	else
	{
	    var count = parseInt($("[stage_id="+stageId+"].kanban-item-wrapper").data('count'));
	 
        $("[stage_id="+stageId+"].kanban-item-wrapper").data('count', ++count);
		$("[stage_id="+stageId+"].kanban-item-wrapper").append(base64_decode(item));
	}
}