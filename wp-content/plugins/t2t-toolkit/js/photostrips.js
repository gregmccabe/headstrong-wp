(function( $ ){

  $.fn.picstrips = function( options ) {  

    var settings = $.extend( {
      'splits': 8, 
      'hgutter': '10px', 
      'vgutter': '60px', 
      'bgcolor': '#fff'
    }, options );

    return this.each( function() {

      var parent_container = $(this).parent();
  
      var that = this;   

      function doStrips() {
        var h = $(that).height(),
            w = $(that).width(),
            sw = (w / settings.splits) - parseInt(settings.hgutter), //width of a strip
            spstyle = "position: absolute; left: 0px; width: " + sw + "px; height: " + settings.vgutter + "; top: ";
        var cnt = $("[id^=molbars_]").length + 1;
 
        $( '<div id="molbars_' + cnt + '" style="height:'+(h+parseInt(settings.vgutter))+'px"></div>' ).insertAfter( $(that) );

        for ( var lp = 0; lp < settings.splits; lp++ ) {
          var voffs = lp % 2 != 0 ? '0px' : (h - parseInt( settings.vgutter )) + 'px';

          if(lp % 2 != 0) {
            var top_margin = parseInt(settings.vgutter);
          } else {
            var top_margin = "-"+parseInt(settings.vgutter);
          }

          var p_width = parent_container.width();
          var p_height = parent_container.height();

          clstyle = "position: relative; float:left; margin-right: " + settings.hgutter + "; background-image: url('" + that.src + "'); width: " + sw + "px; height: " + h + "px; top:" + top_margin + "px;";

          clstyle += " background-position: -" + (w - ((settings.splits - lp) * sw)) + "px 100%;";

          clstyle += " background-size: "+p_width+"px "+p_height+"px;";

          $( '<div style="' + clstyle + '"><span style="' + spstyle + voffs + '"></span></div>' ).appendTo( $( '#molbars_' + cnt ) );  
        };
        $(that).hide();
      }

      //make sure image has finished loading
      if ( !this.complete || this.width + this.height == 0 ) {
        var img = new Image; 
        img.src = this.src;
        $(img).load( function () {
          doStrips();
        });
      }
      else {
        doStrips();
      }

    });
  };
})( jQuery );
