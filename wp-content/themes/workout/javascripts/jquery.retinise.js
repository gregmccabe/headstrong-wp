/*  RETINISE.JS --------------------------------------------------*

  Author:         Simon Sturgess
                  @dahliacreative
                  simon@dahliacreative.com
                  http://www.dahliacreative.com
          
  Thanks to:      Pedro Piedade
                  @iampedropiedade
                  http://pedropiedade.com/
          
  Documentation:  http://www.dahliacreative.com/retinisejs
  
  Release date:   27/09/2012
  Version:        v.1.0
  Licensing:      © Copyright 2012 DahliaCreative.
                  Free to use under the GPLv2 license.
                  http://www.gnu.org/licenses/gpl-2.0.html
                  
*--------------------------------------------------------------------*/

(function($){
  $.fn.extend({

  retinise: function(params) {

    var defaults = {
      suffix:   "@2x",
      srcattr:  "data-src",
      retattr:  "data-ret",
      altattr:  "data-alt"
    };

    var options = $.extend(defaults, params),
        pixelRatio = window.devicePixelRatio,
        retina = (pixelRatio > 1) ? true : false;

    $(this).each(function() {
      var retImg = $(this),
          display = retImg.css('display');

      retImg.css('display', 'none');

      if(retImg.attr(options.srcattr)) {
        var imgSrc = retImg.attr(options.srcattr),
            imgAlt = retImg.attr(options.altattr),
            imgRetSrc = retImg.attr(options.retattr);

        if (retina === true) {
          if(retImg.attr(options.retattr)) {
            retImg.attr({
              'src': imgRetSrc,
              'alt': imgAlt
            });
          } else {
            retImg.attr({
              'src': imgSrc.replace(/\.\w+$/, function(match) { return options.suffix + match; }),
              'alt':imgAlt
            });
          }
          retImg.load(function () {
            var imgHeight = retImg.height()/pixelRatio,
                imgWidth = retImg.width()/pixelRatio;

            retImg.attr({
              'height': imgHeight,
              'width': imgWidth
            }).css({
              'display': display
            });
          });
        } else {
          retImg.attr({
            'src': imgSrc,
            'alt': imgAlt
          }).css({
            'display': display
          });
        }
      }
    });
  }
});

})(jQuery);