jQuery(document).ready(function(){
	
	jQuery('.loading').hide();
	jQuery('.container').show();
	
	function getParameterByName(name) {
	    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
	    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
	        results = regex.exec(location.search);
	    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
	}	
	
	jQuery('ul.tabs li').click(function(){
		var tab_id = jQuery(this).attr('data-tab');

		jQuery('ul.tabs li').removeClass('current');
		jQuery('.tab-content').removeClass('current');

		jQuery(this).addClass('current');
		jQuery("#"+tab_id).addClass('current');
	})
	
	var page 		= getParameterByName('page');
	var plugin_url	= eval( page + '.plugin_url' );
	
	jQuery.get( plugin_url + 'LICENSE',function(data){
		jQuery('#tab-2').html( data.replace(/(?:\r\n|\r|\n)/g, '<br />') );
	});
	jQuery.get( plugin_url + 'README.md',function(data){
		jQuery('#tab-3').html( data.replace(/(?:\r\n|\r|\n)/g, '<br />') );
	});
	

})