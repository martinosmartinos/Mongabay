// jQuery that needs to run before page renders. Place all other jquery into init.js
jQuery(document).ready(function( $ ) {
   
   $('.featured-image img.attachment-left-sidebar.wp-post-image').each(function(index, element) {
    	alert($(this).height());
	});
   
});
