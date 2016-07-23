// JavaScript Document
jQuery('.images-item img').error(function(e) {
	
    jQuery(this).remove();
	
}); 

jQuery(document).ready(function( $ ) {
	
	// put first word of widget title to em tag
	$('.widgettitle').each(function() {
		var word = $(this).html();
		var index = word.indexOf(' ');
		if(index == -1) {
			index = word.length;
			}
		$(this).html('<em>' + word.substring(0, index) + '</em>' + word.substring(index, word.length));
	});
	
	
	// aside format - move license widget 
	$(".format-aside #mongabay-license-widget-2").appendTo('.sharebox:first-child');
   
   
   /* STICKY SIDEBARS */
	$("aside.left-sidebar").hcSticky({top: 30});
	$("aside.right-sidebar").each(function(index, element) {
		if ($(this).parents('.format-aside').length) return;
		if ($(this).parents('body.single-image').length) return;
		
        if ($(this).parents('body.single-format-standard.single-post').length) {
			var bh = $('#comments-block').height();
			$(this).hcSticky({top: 30, bottomEnd: bh+120});
		} 
		else if ($(this).parents('body.subdomain-images').length) {
			$(this).hcSticky({top: 30, bottomEnd: 350});
		}
		else $(this).hcSticky({top: 30});
    });
	
	/* COMMENT FORM LOGIN */
	$('.must-log-in a').click(function(e) {
        $('.toplinks a[href="#login-modal"]').click();
    });
	
	/* MENU FIXES */
	// var fixlangs = false;
	// var parts = location.hostname.split('.');
	// var subdomain = parts.shift();
	// var langs = ['zh','fr','de','it','ja','es','pt'];
	// if (langs.indexOf(subdomain)!=-1) {
		// var fixlangs = true;
	// } 
	// $('.menu-item a').each(function(index, element) {
       ////$(this).attr('href',$(this).attr('href').replace("mongalocal.com", "mongabaydev.co.uk")); 
		// $(this).attr('href',$(this).attr('href').replace("/list/forum", "/forum"));
		////$(this).attr('href',$(this).attr('href').replace("://kids.", "://kidsnews."));
		
		// if (fixlangs==true) {
			// $(this).attr('href',$(this).attr('href').replace("news.", subdomain+"."));
			// $(this).attr('href',$(this).attr('href').replace("www.", subdomain+"."));
		// }
		
    // });
	
	/* LONG TITLES ON SINGLE POSTS */
	if ($('body.single-post h1.entry-title').text().length > 70) {
		$('body.single-post h1.entry-title').css('font-size','32px');
	}
	
	/* TRY TO RESTORE OLD CAPTIONS */
	$('body.single-post .entry-content-text').each(function(index, element) {
        $('img',this).each(function(index, element) {
            $(this).next('i').addClass('oldcaption');
			 $(this).next('br').next('i').addClass('oldcaption').prev('br').hide();
			 $(this).parent('a').next('i').addClass('oldcaption');
			 $(this).parent('a').next('br').next('i').addClass('oldcaption').prev('br').hide();
			 $(this).parent('a').parent('span').next('i').addClass('oldcaption');
			 $(this).parent('a').parent('span').next('br').next('i').addClass('oldcaption').prev('br').hide();
        });
    });
	
	/* PROPERLY PLACE ADS AT TOP OF THE ARTICLE */
	$('.above-article-ad-cont').each(function(index, element) {
		
		starttag = $('.entry-content-text').children().first();
		 if (starttag.is('figure')) starttag.after($(this));
		 
		 else if (starttag.is('p')) {
			 if (starttag.children().first().is('span') ||
			    starttag.children().first().is('a') ||
				starttag.children().first().is('img'))
			starttag.after($(this));
			else starttag.before($(this));
		 } else starttag.before($(this));
		 
		 $(this).css('display','block');
		 
    });
	
	
	/* LARGE IMAGES */
	$('#image-single-member-expanded').appendTo('body');
	$('#image-single-member-expanded').click(function(e) {
        $(this).fadeOut(400);
    });
	$('.image-single-member').click(function(e) {
        $('#image-single-member-expanded').fadeIn(400);
    });
	
	/* IMAGES LOADER AJAX */
	$('.button-load-images').click(function(e) {
		$(this).attr('data-text',$(this).text());
        $(this).text($(this).text()+' ...');
		 $.ajax({
        url: ajaxurl,
        data: {
            'action':'mongabay_load_images_ajax',
            'start': $('.button-load-images').attr('data-start'),
			 'topic': $('.button-load-images').attr('data-topic'),
			 'location': $('.button-load-images').attr('data-location'),
        },
        success:function(data) {		
			 if (data=='0') $('.button-load-images').fadeOut();
			 else {
				 $('.button-load-images').text($('.button-load-images').attr('data-text'));
				 $($('.button-load-images').attr('data-append')).append(data);
				 $('.button-load-images').attr('data-start',parseInt($('.button-load-images').attr('data-start'))+50);
				 $('.images-item-ajax').each(function(index, element) {
                    if ($(this).css('opacity') === '0') $(this).fadeTo('fast',100);
				     });
               
			 }
        },
        error: function(errorThrown) {
          	$(this).fadeOut();
        }
		
    });  
    });
	
	/* SUB MESSAGE */
	$('.subscribe-message').each(function(index, element) {
        $(this).prependTo('#post-22629');
		$(this).fadeIn(200);
    });
	
	/* TEMP PHOTO BLOCK */
	/*$('#mainnav > li:nth-child(5) > a').attr('href','http://travel.mongabay.com');
	$('#mainnav > li:nth-child(5) > .megamenu').remove();*/
	
	
	
	
	/* THOMAS SCRIPTS - MOBILE VIEW */
	function mobileView() {
	  $(".footer-right").detach().insertBefore('.footer-left');
  
  
	  if ($("body").hasClass("page-id-170")) {
  
  
		  $(".widget_mongabay-newsletter-widget").first().detach().insertAfter('#blockone1');
		  $("#reedwanwidgets__block9-18").detach().insertAfter('#blockone1');
		  $(".widget_mongabay-donate-widget").first().detach().insertBefore('.homeimages-block');
		  $(".widget_mongabay-membership-widget").first().detach().insertAfter('.homeimages-block');
		  $(".newsinline-head-wrap").find(".button").detach().appendTo('.newsinline-block-topic');
  
	  } 
   
	  if ($("body").hasClass("single-post")) {
  
		  $(".widget_mongabay-newsletter-widget").first().detach().appendTo('.single-content');
  
	  }
  
	  if ($("body").hasClass("subdomain-images")) {
  
		  $(".widget_mongabay-photos-widget").detach().insertBefore('.images-block-list');
		  $(".widget_mongabay-donate-widget").detach().appendTo('main');
		  $(".widget_mongabay-membership-widget").detach().appendTo('main');
	  }
  
	  if ($("body").hasClass("single-image")) {
  
		  $(".image-single-nav").detach().insertBefore('.image-header');
		  $(".image-single-buy").detach().insertBefore('.images-block-all');
		  $(".headline").detach().insertAfter('.image-single');
		  $(".widget_mongabay-license-widget").detach().insertBefore('.image-single-buy');
	  }
  }

  $("#mongabay-license-widget-2").detach().prependTo('main');
  $(".widget_mongabay-license-widget").detach().prependTo('main');

  if( document.getElementById('featured-format-content')) {
    $('body').addClass('featured-article');

    $('.theiaStickySidebar').removeClass('theiaStickySidebar');
    
    $('aside.sidebar').detach().appendTo('.single-content');

    $('#comments').wrap(' <div id="comments-wrap"> </div>');

  }

  if( document.getElementById('section-images-wrap')) {
    $('body').addClass('section-images');
  }

  if ($(window).width() < 960) {
    mobileView();
  } 
  
  /* AJAX Update real post views count */
  /* if ($('body').hasClass('single-post')) {
	  
	  // get the post id
	  var elClasses = $('body').attr('class').split( ' ' );
	  for ( var index in elClasses ) {
        if ( elClasses[index].match ( /^postid-\d+$/ ) ) {
            var postid = elClasses[index].split ( '-' )[1];
            break;
        }
    }
	 if (typeof(postid) != "undefined" && postid !== null) {
		 
	  jQuery.ajax({
        url: ajaxurl,
        data: {
            'action':'mongabay_ajax_real_read_count',
            'postid' : postid,
        },
	  });
		 
	  
	 }
	 
  } */
  
	
});
