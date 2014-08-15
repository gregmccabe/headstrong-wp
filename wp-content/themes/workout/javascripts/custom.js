jQuery(document).ready(function($) {

	// modified Isotope methods for gutters in masonry
	$.Isotope.prototype._getMasonryGutterColumns = function() {
	  var gutter = this.options.masonry && this.options.masonry.gutterWidth || 0;
	      containerWidth = this.element.width();

	  this.masonry.columnWidth = this.options.masonry && this.options.masonry.columnWidth ||
	                // or use the size of the first item
	                this.$filteredAtoms.outerWidth(true) ||
	                // if there's no items, use size of container
	                containerWidth;

	  this.masonry.columnWidth += gutter;

	  this.masonry.cols = Math.floor( ( containerWidth + gutter ) / this.masonry.columnWidth );
	  this.masonry.cols = Math.max( this.masonry.cols, 1 );
	};

	$.Isotope.prototype._masonryReset = function() {
	  // layout-specific props
	  this.masonry = {};
	  // FIXME shouldn't have to call this again
	  this._getMasonryGutterColumns();
	  var i = this.masonry.cols;
	  this.masonry.colYs = [];
	  while (i--) {
	    this.masonry.colYs.push( 0 );
	  }
	};

	$.Isotope.prototype._masonryResizeChanged = function() {
	  var prevSegments = this.masonry.cols;
	  // update cols/rows
	  this._getMasonryGutterColumns();
	  // return if updated cols/rows is not equal to previous
	  return ( this.masonry.cols !== prevSegments );
	};

	// Schedule
	$(".program_filter").change(function() {

		// Set the current filter and calendar
		var this_calendar = $(this).attr("data-calendar_id"); 
		var this_filter = $(this).find("option:selected").val();
		var all_events = $.parseJSON($(this).attr("data-all_events"));

		$("#"+this_calendar).fullCalendar("removeEvents")
		$("#"+this_calendar).fullCalendar("addEventSource", all_events);

		if(this_filter != "all") {
			$("#"+this_calendar).fullCalendar("removeEvents", function(event) {
	    	return this_filter != event.id;
	    });
	  }
		
	})
	.fancySelect()
	.css("visibility", "visible");


	$(window).load(function() {

		$(".calendar").each(function() {

			// Get the wrapper
			var this_calendar_wrapper = $(this);

			// Calendar object
			var this_calendar = this_calendar_wrapper.find(".fc");

			// Start and end dates
			var today = new Date();
			today.setHours(0,0,0,0)

			var start_date = this_calendar.fullCalendar('getView').start;

			var end_date = this_calendar.fullCalendar('getView').end;
			end_date.subtract("days", 1);

			this_calendar_wrapper.find(".calendar_nav a").click(function() {

				$(this).parent().find("a").show();

				// Visible day
				var visible_date = this_calendar.fullCalendar('getView').start;

				// Next day
				if($(this).hasClass("next_day")) {

					visible_date.add("days", 1);

					if(visible_date.toDate().toString() == end_date.toDate().toString()) {
						$(this).hide();
					}
					this_calendar.fullCalendar('next');

				}

				// Prev day
				if($(this).hasClass("prev_day")) {

					visible_date.subtract("days", 1);

					if(visible_date.toDate().toString() == start_date.toDate().toString()) {
						$(this).hide();
					}
					this_calendar.fullCalendar('prev');

				}

			});

		});
	});


	// Program filter
	$("ul.options li").each(function() {
		var this_li = $(this);
		var this_value = this_li.attr("data-value");
		var this_color = this_li.attr("data-color");
		var this_text = this_li.text();

		if(this_value == "all") {
			this_li.html("<span class=\"entypo-layout\"></span> "+this_text);
		} else {
			this_li.html("<span class=\"program_color\" style=\"background: "+ this_color +";\"></span> "+this_text);
		}
	});


	// Navigation
	$("header nav ul").first().mobileMenu();
	$("header nav select").fancySelect();
	$(".orderby").fancySelect();

	if($("body").hasClass("homepage")) {
		var headroom_offset = $(window).height();
 	} else {
 		var headroom_offset = 400;
 	}

	$("header").headroom({
		offset: headroom_offset,
		classes : {
      initial : "headroom",
      pinned : "slideDown",
      unpinned : "slideUp"
    }
	});

	function mainmenu(){
	  $("header nav ul li ul li:has(ul)").addClass("with_dropdown");
	  
	  $("header nav ul li").hover(function(){
	  	$(this).find('ul:first').stop(true,true).fadeIn();
	  },function(){
	  	$(this).find('ul:first').stop(true,true).fadeOut();
	  });
  }
  mainmenu();

  // Page content
	$("#content").waypoint(function() {
	    $("header").toggleClass("stuck");
	}, {
	    offset: 120
	})

	// Page title alignment
	var header_height = 360;
	var page_title_height = $("#page_title").height();
	var page_title_top = (header_height - page_title_height);

	if($(document.body).hasClass("admin-bar")) {
		page_title_top += 28;
	}

	if($(document.body).hasClass("header-centered")) {
		page_title_top += 45;
	}

	$("#page_title").css("top", (page_title_top/2+20) +"px");

	// Element aniamtions
	// if($.isFunction($.appear)) {
		function gridAnimate(elements) {
			$(elements).appear();
			$(elements).on('appear', function(event, $all_appeared_elements) {
				$(elements).each(function(i){
				  var row = $(this);
				  setTimeout(function() {
				    row.addClass("animate");
				  }, (300*i));
				});
			});
			$(window).trigger("scroll");
		}

		gridAnimate(".coach_box");
		gridAnimate(".program");
		gridAnimate(".gallery .wall_entry");
		gridAnimate(".post");
	// }

	// Coaches
	$(".coach_box").each(function() {
		var this_box = $(this);

		var box_height = this_box.height();

		this_box.css("height", box_height);

		this_box.hover(function() {
			this_box.find(".role, .social").stop(true, true).animate({
				"margin-top" : "0px",
				"opacity" : 1
			}, 300);
		}, function() {
			this_box.find(".role, .social").stop(true, true).animate({
				"margin-top" : "-32px",
				"opacity" : 0
			}, 300);
		});
	});

	// Galleries
	if($.isFunction($.fancybox)) {
		$(".fancybox").fancybox({
			padding     : 0,
			openEffect  : 'fade',
			closeEffect : 'fade',
			prevEffect	: 'fade',
			nextEffect	: 'fade',
			helpers	: {
				title	: {
					type: 'inside'
				},
				thumbs	: {
					width	 : 50,
					height : 50
				},
				buttons	: {}
			}
		});
	}

	// Main masonry function
	function initializeMasonry(this_elem, options) {
	  var $masonry_container = $(this_elem);     

	  $masonry_container.hide();
	  
	  $masonry_container.imagesLoaded( function(){

	  	$masonry_container.show();
	    
	    $masonry_container.isotope(options);
	  });
	}

  // Blog Masonry
  $(".masonry").each(function() {
		initializeMasonry($(this), {
      itemSelector : $("> div", this),
      resizable: true,
		  masonry : {	
		  	gutterWidth : 15
		  }
    });
  });

	$(".galleries").each(function() {
		if($(this).find(".filter_list").length > 0) {

			var this_album = $(this);

			var $container = this_album.find(".filter_content");

			initializeMasonry($container, {
				itemSelector : '.filter_content .element',
			  resizable: true,
			  layoutMode : 'fitRows' 
			});

			// filter items when filter link is clicked
			this_album.find('.filter_list a').click(function(){
			  var selector = $(this).attr('data-filter');
			  $container.isotope({ filter: selector });
				this_album.find('.filter_list li a').removeClass('active');
		  	$(this).addClass('active');
			  return false;
			});

		}
	});

	function albumHovers() {
		$(".gallery .wall_entry").each(function() {

			var icon = $(this).find(".hover .icons");

			if(icon.length > 0) {
				var image_height = $(this).height();
				var image_width = $(this).width();

				var hover_css = "display: inline-block !important; height: "+(image_width/9)+"px !important; width: "+(image_width/9)+"px !important;";
				var hover_a_css = hover_css+" font-size: "+(image_width/13)+"px !important; line-height: "+(image_width/9)+"px !important;";
				var hover_span_css = hover_css+" font-size: "+(image_width/15)+"px !important; line-height: "+(image_width/10)+"px !important;";

				icon.find("a").css('cssText', hover_a_css);
				icon.find("span").css('cssText', hover_span_css);

				var icon_height = icon.height();
				var icon_width = icon.width();
				
				icon.css({
					"margin-top"  : "-"+(icon_height/2)+"px",
					"margin-left" : "-"+(icon_width/2)+"px"
				});
			}

		});

		$(".gallery .wall_entry").on({
			mouseenter: function() {
				$(this).find(".hover").stop(true, true).animate({ "opacity" : 1 }, 400);
				$(this).find(".hover .icons").stop(true, true).animate({
					"top" : "50%"
				}, 400);
			},
			mouseleave: function() {
				$(this).find(".hover").stop(true, true).animate({ "opacity" : 0 }, 400);
				$(this).find(".hover .icons").stop(true, true).animate({
					"top" : "0%"
				}, 400);
			}
		});

		$(".albums.thumbnail_caption_overlay .element").on({
			mouseenter: function() {
				$(".caption", this).stop(true, true).fadeIn(500);
			},
			mouseleave: function() {
				$(".caption", this).stop(true, true).fadeOut(500);
			}
		});
	}
	$(window).load(function() {
		albumHovers();

		$(window).resize(function() {
			if ($(window).width() < 768) {
				$(".fc").fullCalendar('changeView', 'agendaDay');
				$(".calendar_nav").show();
			} else {
				$(".fc").fullCalendar('changeView', 'agendaWeek');
				$(".calendar_nav").hide();
			}
		}).trigger("resize");
	});
	

	// Carousels
	function enable_carousels() {
		$(".jcarousel").each(function() {

			var this_carousel = $(this);

			var columns = 3;
			if(typeof this_carousel.attr("data-columns") != "undefined") {
				var columns = this_carousel.attr("data-columns");
			}	   

			var carousel = this_carousel.on('jcarousel:create jcarousel:reload', function() {
	      var element = $(this),
	          width = element.innerWidth();     

	      if (width > 768) {
	          width = width / columns;
	      } else if (width > 600) {
	          width = width / (columns-1);
	      }

	      element.jcarousel('items').css('width', width + 'px');
	    }).jcarousel();

	    if(this_carousel.find("li").length > columns) {

			  this_carousel.parent().find(".jcarousel-prev").on("jcarouselcontrol:active", function() {
			      $(this).show();
			  });
			  this_carousel.parent().find(".jcarousel-prev").on("jcarouselcontrol:inactive", function() {
			      $(this).hide();
			  });
			  this_carousel.parent().find(".jcarousel-prev").jcarouselControl({
		        target: "-=1",
		        carousel: carousel
		    });

			  this_carousel.parent().find(".jcarousel-next").on("jcarouselcontrol:active", function() {
			      $(this).show();
			  });
			  this_carousel.parent().find(".jcarousel-next").on("jcarouselcontrol:inactive", function() {
			      $(this).hide();
			  });
		    this_carousel.parent().find(".jcarousel-next").jcarouselControl({
		        target: "+=1",
		        carousel: carousel
		    });
		  }

		});

		// // Hide nav if less than 3 widgets
		if($("footer#carousel").find(".widget").length < 4) {
			$("footer#carousel").find(".jcarousel-nav").hide();
		}
	}
	enable_carousels();


	// Footer
	if($("footer#carousel").length > 0) {

		var footer_carousel = $("footer#carousel");

		footer_carousel.clone().addClass("shrink floating").removeClass("bottom").insertAfter("footer#carousel");

		var page_height = $(document).height();
		var section_height = $("section").last().height();
		var footer_height = $("footer").height();

		$("section").last().css("height", section_height);

		$(window).scroll(function() {

			var this_footer = $("footer#carousel.floating");
			var scrollBottom = $(document).height() - $(window).height() - $(window).scrollTop();
			var footer_height = $("footer#standard").height();
			// var scrollBottom = (scrollBottom-footer_height);

			var footer_top = $('footer#carousel.bottom').height()+$('footer#standard').height();

			if(scrollBottom <= footer_top) {
				this_footer.fadeOut("fast");
			} else {
				this_footer.fadeIn("fast");
			}
		});		

		$("footer#carousel.floating").hoverIntent({
			over: function() {
				enable_carousels();
				if($(this).hasClass("shrink")) {
					$("footer#carousel.floating").stop(true,true).removeClass("shrink").animate({
						'bottom' : '0px'
					}, 400);
				}
			},
			out: function() {
				if(!$(this).hasClass("bottom")) {
					$("footer#carousel.floating").stop(true,true).addClass("shrink").animate({
						'bottom' : '-70px'
					}, 400);
				}
			}
		});
	}

	// Backstretch
	if($.isFunction($.backstretch)) {
		$(".backstretch").each(function() {
			var bg = $(this).attr("data-background-image");
			if(bg) {
				$(this).backstretch(bg, {fade: 500});
			}
		});
	}

	// Retina logo
	$('.logo-retina').retinise();

	// Back to top button
	$().UItoTop({ 
		text: '<span class="entypo-up-open"></span>',
		easingType: 'easeOutQuart' 
	});

	// Tipsy
	$('a[rel=tipsy]').tipsy({fade: true, gravity: 's', offset: 0});

	$(".splash").each(function() {
		this_slider = $(this);
		
		$(window).resize(function() {
		  this_slider.find(".slide-content").each(function() {
		    var slider_height = $(".splash").outerHeight();
		    var height = $(this).height();

		    $(this).css("margin-top", "-"+ (height/2) +"px");

		  });
		}).trigger("resize");
	});
	

	if($("body").hasClass("homepage")) {
		$(window).resize(function() {

			var window_height = $(this).height();
			var slider_width = $("#slider_container").width();
			var slider_height = $("#slider_container").height();

			if(window_height < 765) {
				$(".ei-slider, .sl-slider-wrapper, .splash, .flexslider li").css("height", (window_height-215)+"px");
			} else {
				$(".ei-slider, .sl-slider-wrapper, .splash, .flexslider li").css("max-height", "550px");
			}

			$("#slider_container").css({
				"margin-left" : "-"+(slider_width/2)+"px"
			})

			$("#content").first().css("margin-top", (slider_height+200)+"px");
		}).trigger("resize");
	}
	

});