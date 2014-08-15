// Sliders
jQuery(document).ready(function($) {
  if($(".slitslider").length > 0) {

    $(".slitslider").each(function() {

      var this_slider = $(this);
      var autoplay = this_slider.attr("data-autoplay");
      if(autoplay == "false") {
        autoplay = false;
      } else {
        autoplay = true;
      }
      var interval = this_slider.attr("data-interval")+"000";

      var Page = (function() {

        $(window).resize(function() {
          this_slider.find(".sl-slider").find(".bg-img").each(function() {
            $(this).css({
              height : $(".sl-slider-wrapper").height()+"px",
              width : $(".sl-slider-wrapper").width()+"px"
            });
            $(this).backstretch($(this).attr("data-background"));
          });

          this_slider.find(".sl-slider").find(".slide-content").each(function() {
            var slider_height = $(".sl-slider-wrapper").outerHeight();
            var height = $(this).height();

            $(this).css("margin-top", "-"+ (height/2) +"px");

          });
        }).trigger("resize");
        
        var $navArrows = this_slider.find('.nav-arrows'),
          $nav = this_slider.find('.nav-dots > span'),
          slitslider = this_slider.find(".sl-slider-wrapper").slitslider( {
            autoplay: autoplay,
            speed: 800,
            interval: interval,
            onBeforeChange : function( slide, pos ) {
              $nav.removeClass( 'nav-dot-current' );
              $nav.eq( pos ).addClass( 'nav-dot-current' );
            }
          } ),
          init = function() {
            initEvents();
          },
          initEvents = function() {
            // add navigation events
            $navArrows.children(':last').on( 'click', function() {
              slitslider.next();
              return false;
            });

            $navArrows.children(':first').on( 'click', function() {
              slitslider.previous();
              return false;
            });

            $nav.each( function( i ) {
              $( this ).on( 'click', function( event ) {
                var $dot = $( this );
                if( !slitslider.isActive() ) {
                  $nav.removeClass( 'nav-dot-current' );
                  $dot.addClass( 'nav-dot-current' );
                }
                slitslider.jump( i + 1 );
                return false;
              } );
            } );
          };
          return { init : init };
      })();

      Page.init();  
      $(".slitslider .slide-content").css("visibility", "visible");

    });

  }
  
  if($(".ei-slider").length > 0) {

    $(".ei-slider").each(function() {

      var this_slider = $(this);
      var autoplay = this_slider.attr("data-autoplay");
      if(autoplay == "false") {
        autoplay = false;
      } else {
        autoplay = true;
      }
      var interval = this_slider.attr("data-interval")+"000";

      $(window).resize(function() {
        this_slider.find(".slide-content").each(function() {
          var slider_height = $(".ei-slider").outerHeight();
          var height = $(this).height();

          $(this).css("margin-top", "-"+ (height/2) +"px");

        });
      }).trigger("resize");

      this_slider.eislideshow({
        easing      : 'easeOutExpo',
        titleeasing : 'easeOutExpo',
        autoplay    : autoplay,
        slideshow_interval   : parseInt(interval),
        titlespeed  : 1500
      });
      $(".ei-slider .slide-content").css("visibility", "visible");

    });
  }
});

;(function($) {
  $(window).load(function(){
    // Flexslider
    $(".flexslider").each(function() {

      var this_slider = $(this);

      var autoplay = this_slider.attr("data-autoplay");
      if(autoplay == "false") {
        autoplay = false;
      } else {
        autoplay = true;
      }

      var smooth_height = this_slider.attr("data-smooth_height");
      if(smooth_height == "false") {
        smooth_height = false;
      } else {
        smooth_height = true;
      }
      
      var interval = this_slider.attr("data-interval")+"000";
      var effect = this_slider.attr("data-effect");

      $(this_slider).flexslider({
        animation: effect, 
        smoothHeight: smooth_height,
        slideshow: autoplay,
        slideshowSpeed: parseInt(interval),
        animationSpeed: 600,
        video: false,
        controlNav: false,
        prevText: "",
        nextText: "",
        start: function() {

          this_slider.find(".slide-content").hide();

          setTimeout(function() {
            $(window).resize(function() {
              this_slider.find(".slide-content").each(function() {
                var height = $(this).height();

                $(this).css("margin-top", "-"+ (height/2) +"px");
                $(this).fadeIn("normal");
              });
            }).trigger("resize"); 
          }, 100);

          $(this_slider).find("li").each(function() {
            if($(this).attr("data-image")) {
              $(this).backstretch($(this).attr("data-image"));
            }
          });
        }
      });

    });

    // Before and after
    $(".before_after").each(function() {

      var container_width = $(this).find("img:first").width();

      $(this).css("width", container_width);

      var offset = $(this).attr("data-default_offset_pct");
      $(this).twentytwenty({default_offset_pct: offset });  
    });

    // Loupe
    $(".photo_loupe").each(function() {
      var lens_size = $(this).attr("data-lens-size");

      $(this).imageLens({ lensSize: lens_size, lensCss: 'loupe_magnify' });
    });

    // Photo strips
    $(".photo_strips").each(function() {

      var container = $(this);
      var container_width = $(this).width();
      var container_height = $(this).height();

      container.css({
        width: container_width,
        height: container_height
      });

      var strips = $("img", this).attr("data-strips");
      var h_spacing = $("img", this).attr("data-horizontal_spacing");
      var v_spacing = $("img", this).attr("data-vertical_spacing");

      $("img", this).picstrips({
        splits: strips, 
        hgutter: h_spacing+'px', 
        vgutter: v_spacing+'px'
      });

    });

  });
})(jQuery);

jQuery(document).ready(function($){ 

  // Backstretching
  $(".callout_banner").each(function() {
    if($(this).attr("data-background-image")) {
      $(this).backstretch($(this).attr("data-background-image"));
    }
  });

  // Fitvids
  $(".container").fitVids();

  // Progress bars
  $(".progress_bar").each(function() {

    $(this).appear();
    $(this).on('appear', function(event, $all_appeared_elements) {
      if(!$(this).hasClass("appeared")) {
        $(this).addClass("appeared");
        var width = $(this).attr("data-width");
        $(this).find("div").animate({ width: width+"%" }, 1200);
      }
    });
    
  });

  // Pie charts
  $(".pie_chart").each(function() {

    var container_width = $(this).parent().width();
    var legend_style = $(this).attr("data-legend_style");
    var line_width = $(this).attr("data-line_width");
    var bar_color = $(this).attr("data-bar_color");
    var background_color = $(this).attr("data-background_color");
    var chart_size = $(this).attr("data-chart_size");
    var percentage = $(this).attr("data-percent");

    $(this).css("width", container_width+"px");
    $(this).find(".chart_icon").css("font-size", (container_width/4)+"px");

    $(this).find(".percentage").easyPieChart({
        animate: 1500,
        barColor: bar_color,
        trackColor: background_color,
        lineWidth: line_width,
        size: container_width, 
        scaleColor: false,
        onStep: function(value) {
          if(legend_style == "percentage") {
            this.$el.find('span').text(~~value);
          }
        }
    });

    $(this).appear();
    $(this).on('appear', function(event, $all_appeared_elements) {
      if(!$(this).hasClass("appeared")) {
        $(this).addClass("appeared");
        $(this).find(".percentage").data('easyPieChart').update(percentage);
      }
    });
  });

  // Photo grids
  $(".photo_grid").each(function() {

    var this_grid = $(this);

    var rel = Date.now();
    var layout = $(this).attr("data-layout");
    var gutter = $(this).attr("data-gutter");
    var fancybox = $(this).attr("data-fancybox");

    if(fancybox == "true") { var fancy_open = true; } else { var fancy_open = false; }

    $(this).photosetGrid({
      gutter: gutter+'px',
      layout: layout,
      highresLinks: fancy_open,
      rel: rel,
      onComplete: function(){
        $(this_grid).attr('style', '');
        // Fancyboxes
        $(this_grid).find(".highres-link").fancybox({
          openEffect  : 'fade',
          closeEffect : 'fade',
          prevEffect  : 'fade',
          nextEffect  : 'fade',
          padding     : 0,
          helpers : {
            thumbs  : {
              width : 50,
              height  : 50
            },
            buttons : {}
          }
        });

      }
    });
  });

  // Toggle lists
  $(".toggle_box .title").click(function() {
    var content_container = $(this).parent().find(".content");
    if(content_container.is(":visible")) {
      content_container.slideUp("fast");
      $(this).find("a.toggle_link").text($(this).find("a.toggle_link").data("open_text"));
    } else {
      content_container.slideDown("fast");
      $(this).find("a.toggle_link").text($(this).find("a.toggle_link").data("close_text"));
    }
  });
  
  $(".toggle_box .title").each(function() {
    $(this).find("a.toggle_link").text($(this).find("a.toggle_link").data("open_text"));
    if($(this).parent().hasClass("opened")) {
      $(this).find("a.toggle_link").parent().trigger("click");
    }
  });

  // Tabs
  $(".tabs").find(".pane:first").show().end().find("ul.nav li:first").addClass("current");
  $(".tabs ul.nav li a").click(function() {
    var tab_container = $(this).parent().parent().parent();
    $(this).parent().parent().find("li").removeClass("current");
    $(this).parent().addClass("current");
    $(".pane", tab_container).hide();
    $("#"+$(this).attr("class")+".pane", tab_container).show();
  });

});