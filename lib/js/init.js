
// Copyright 2018 GPLv3, Zillexplorer by Mike Kilday: http://DragonFrugal.com


// Wait until the DOM has loaded before querying the document
$(document).ready(function(){
	
	////////////////////////////////////////////////////////
	
  function setHeights() {
    footer_height = $('#site-footer').innerHeight();
    adjust_height = $(window).innerHeight() - footer_height - 78; // Minus footer area height, and an extra few px
    $('#main-content').css('min-height', adjust_height);
    
  };
  setHeights();
  
  $(window).resize(function() {
    setHeights();
  });
  
	////////////////////////////////////////////////////////
	
	$.each($('textarea[data-autoresize]'), function() {
    var offset = this.offsetHeight - this.clientHeight;
 
    var resizeTextarea = function(el) {
        $(el).css('height', 'auto').css('height', el.scrollHeight + offset);
    };
    
    $(this).each(function() { resizeTextarea(this); }).removeAttr('data-autoresize');  // Onload
    
    $(this).change(function() { resizeTextarea(this); }).removeAttr('data-autoresize');  // Onchange
    
    $(this).on('keyup input', function() { resizeTextarea(this); }).removeAttr('data-autoresize'); // On keyup
    
});
	
				
	//////////////////////////////////////////////////////////
  
  
	$('ul.tabs').each(function(){
	// For each set of tabs, we want to keep track of
	// which tab is active and it's associated content
	var $active, $content, $links = $(this).find('a');

	// If the location.hash matches one of the links, use that as the active tab.
	// If no match is found, use the first link as the initial active tab.
	$active = $($links.filter('[href="'+location.hash+'"]')[0] || $links[0]);
	$active.addClass('active');

	$content = $($active[0].hash);

	    // Hide the remaining content
	    $links.not($active).each(function () {
	    $(this.hash).hide();
	    });

	    // Bind the click event handler
	    $(this).on('click', 'a', function(e){
	    // Make the old tab inactive.
	    $active.removeClass('active');
	    $content.hide();
  
	    // Update the variables with the new link and content
	    $active = $(this);
	    $content = $(this.hash);
  
	    // Make the tab active.
	    $active.addClass('active');
	    $content.show();
  
	    // Prevent the anchor's default click action
	    e.preventDefault();
	    });
	  
	
	});
	
	//////////////////////////////////////////////////////////

});