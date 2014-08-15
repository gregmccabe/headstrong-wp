jQuery(document).ready(function($) {

  function codeAddress(address) {
    var latitude,
        longitude;

        console.log(address);

    if(address == "#location_address") {
      latitude = $("#location_latitude");
      longitude = $("#location_longitude");
    } else {
      latitude = $("#map-latitude");
      longitude = $("#map-longitude");
    }

    var geocoder= new google.maps.Geocoder();

    geocoder.geocode( { 'address': $(address).val() }, function(results, status) {
      if (status == google.maps.GeocoderStatus.OK) {
        latitude.val(results[0].geometry.location.lat());
        longitude.val(results[0].geometry.location.lng());
      } else {
        console.log('Geocode was not successful for the following reason: ' + status);
      }
    });
  }

  $("#map-geocode_search, #location_geocode_search").click(function() {
    var address;

    if($(this).attr("id") == "location_geocode_search") {
      address = "#location_address";
    } else {
      address = "#map-address";
    }
    codeAddress(address);
  });

  String.prototype.capitalize = function() {
    return this.charAt(0).toUpperCase() + this.slice(1);
  }

  // Maxlength for textareas
  $.fn.extend( {
    limiter: function(limit, elem) {
      $(this).on("keyup focus", function() {
        setCount(this, elem);
      });
      function setCount(src, elem) {
        var chars = src.value.length;
        if (chars > limit) {
          src.value = src.value.substr(0, limit);
          chars = limit;
        }
        var remaining = (limit - chars);
        var characters = "characters";
        if(remaining == 1) {
          var characters = "character";
          elem.removeClass("limit_red");
        } else if(remaining == 0) {
          elem.addClass("limit_red");
        } else {
          elem.removeClass("limit_red");
        }
        elem.html(remaining+" "+characters+" left");
      }
      setCount($(this)[0], elem);
    }
  });

  $(".textarea-limit").each(function() {
    var this_textarea = $("textarea#"+$(this).attr("id").split("-limit")[0]);

    this_textarea.limiter(this_textarea.attr("maxlength"), $(this));
  });

  $(document).on({
    mouseenter: function () {
      $(this).addClass("button-primary");
    },
    mouseleave: function () {
      $(this).removeClass("button-primary");
    }
  }, ".schedule .time");

  $(".schedule .add").click(function() {
    var day = $(this).parent().find(".day").text();
    $(".schedule").hide();
    $(".schedule_form").fadeIn().find("h2").text("Add Hours To "+day.capitalize());
    $(".schedule_form").find(".button-primary").text("Add Hours →");
    $(".schedule_form").removeClass("edit").addClass("new");
    $(".schedule_form").data("day", day.toLowerCase());
  });

  $(document.body).on("click", ".schedule .time a.edit_time", function() {
    var day = $(this).parent().parent().find(".day").text();

    $(".schedule").hide();
    $(".schedule_form").fadeIn().find("h2").text("Edit Hours For "+day.capitalize());
    $(".schedule_form").find(".button-primary").text("Edit Hours →");
    $(".schedule_form").removeClass("new").addClass("edit");
    $(".schedule_form").data("day", $(this).parent().attr("id"));

    var values = $(this).parent().find("input").val().split(",");
    $(".schedule_form").find(".schedule_end_time").select2("val", values[1]);
    $(".schedule_form").find(".schedule_start_time").select2("val", values[0]);
  });


  $(document.body).on("click", ".schedule .time a.delete_time", function() {
    $(this).parent().remove();
  });

  // Cancel form
  $(".schedule_form .cancel").click(function() {
    $(".schedule").fadeIn();
    $(".schedule_form").hide();
    $('.schedule_start_time').select2("val", "00:00");
    $(".schedule_end_time").select2("val", "00:00");
  });

  $('.schedule_start_time').select2();

  // Submit new form
  $(document.body).on("click", ".schedule_form.new .button-primary", function() {
    var this_form = $(".schedule_form");
    var day = this_form.data("day");
    var time = this_form.find(".schedule_start_time option:selected");
    var duration = this_form.find(".schedule_end_time option:selected");

    var html = "<li class='time'>";
    html += "<span>"+time.text()+"</span>";
    html += '<input type="hidden" name="'+day+'_time[]" value="'+time.val()+','+duration.val()+'">';
    html += "<a href=\"javascript:;\" class=\"edit_time\"><i class=\"typicons-pencil\"></i></a>";
    html += "<a href=\"javascript:;\" class=\"delete_time\"><i class=\"typicons-delete\"></i></a>";
    html += "</li>";

    $("ul."+day+" li.add").before(html);

    this_form.find(".cancel").trigger("click");
  });

  // Edit exisiting form
  $(document.body).on("click", ".schedule_form.edit .button-primary", function() {
    var this_form = $(".schedule_form");
    var day = this_form.data("day");
    var time = this_form.find(".schedule_start_time option:selected");
    var duration = this_form.find(".schedule_end_time option:selected");

    console.log(day)

    $("#"+day).find("input").val(time.val()+','+duration.val());
    $("#"+day).find("span").text(time.text());

    this_form.find(".cancel").trigger("click");
  });


  // Datepicker
  $(".t2t_datepicker_clear").click(function() {
    $(this).parent().find("input").val("");
  });

  // Copy to clipboard
  $('#copy-to-clipboard').zclip({
    path: t2t_toolkit_path+'js/ZeroClipboard.swf',
    copy: function() {
      var copy_text = "";
      $('.copy-to-clipboard-target').find("tbody tr").each(function() {
        copy_text += $(this).find("td").text().split(":").join(": ")+"\n";
      });
      return copy_text;
    },
    afterCopy: function() {
      $('#copy-to-clipboard').html("<span class='entypo-check'></span>&nbsp; Copied to Clipboard!");
    }
  });

  // Post meta
  $(".t2t-post-option-row select").each(function() {
    var required = ($(this).find("option").first().val() == "");

    $(this).select2({
      allowClear: required
    });
  });

  $("#button_post_id").change(function() {
    if($(this).parent().parent().find("#external_url").length != 1) {
      if($(this).find("option:selected").val() == "") {
        $(this).parent().next().hide().next().hide().next().hide();
      } else {
        $(this).parent().next().show().next().show().next().show();
      }
    }
  }).trigger("change");

  // Post formats
  $("#postformat_metabox .t2t-post-option-row").hide().first().show();
  $("#postformat-select").change(function() {
    var selected = $(this).find("option:selected").val();

    $("#formatdiv").find("#"+"post-format-"+selected).attr("checked", "checked");

    $("#postformat_metabox .t2t-post-option-row").hide().first().show();
    $("#postformat_metabox").find("."+"post-format-"+selected).parent().show();
  }).trigger("change");

	// Shortcodes
 	$("#shortcode-select, #shortcode_metabox .rm_section select").select2({
    allowClear: true
  });

  // Load in page list
  if($("#button_post_id").length > 0) {
    $.ajax({
      url: ajaxurl,
      dataType: 'json',
      data: {
          'action' : 'get_post_list'
      },
      success: function(data) {
        var select = $("#button_post_id");

        $.each(data, function(group, items) {
          var optgroup = $("<optgroup>", {label: group});;
          optgroup.appendTo(select);

          $.each(items, function(option, item) {

            var option = $("<option>", {text: item.text, value: item.id});

            option.appendTo(optgroup);
          });

          select.select2("val", select.attr("data-value"));

        });
      }
    });
  }
  
	$('#shortcode-select').change(function() {
		$('.rm_section').hide();
		$('#div_'+$(this).val())
      .fadeIn()
      .find("input,textarea").first().focus();
	});

	$('.shortcode_button').click(function() {
		var target = $(this).attr('id');
		var gen_shortcode = '';
  		gen_shortcode+= '['+target;

  		if($('#'+target+'_attr_wrapper .attr').length > 0) {
  			$('#'+target+'_attr_wrapper .attr').each(function() {
  			  if($(this).attr("id") != target+'-content') {
  			    if($(this).val() != "") {
  			      attr_name = $(this).attr('name').split(target+"_")[1];
              var val = $(this).val();
              var escaped = val.replace(/\[/g, "&#91;").replace(/\]/g, "&#93;");
				      gen_shortcode+= ' '+attr_name+'="'+escaped+'"';
			      }
			    }
			  });
		  }

		  gen_shortcode+= ']';
		  if($('#'+target+'-content').length > 0) {
  			gen_shortcode+= $('#'+target+'-content').val()+'[/'+target+']';
  			gen_shortcode+= '\n';
  		}
      // $('#'+target+'-code').val(gen_shortcode);

  		if(jQuery("textarea.wp-editor-area").css("display") == "none") {
        tinyMCE.execCommand("mceInsertContent",false, gen_shortcode);
      } else {
        var original_text = jQuery("textarea.wp-editor-area").val();
        jQuery("textarea.wp-editor-area").val(original_text + gen_shortcode);
      }

      $('.rm_section').hide();
      $('#shortcode-select').select2("val", "");
      $("#shortcode_metabox").find("input[type='text'], textarea, input[type='hidden']").val("")
        .end().find("select,.icon_selector").select2("val", "");
      $("#shortcode_metabox").find(".t2t-gallery-thumbs ul li").remove();

	});

	// Select dropdowns
	function format(icon) {
      if (!icon.id) return icon.text; // optgroup
      return '<span class="icon ' + icon.text + '"></span> ' + icon.text;
  }
  $(".icon_selector").select2({
    data: t2t_icons,
    formatResult: format,
    formatSelection: format,
    allowClear: true,
    escapeMarkup: function(m) { return m; }
  });

  function formatPostFormats(icon) {
    // standard is a effed up exception
    if(parseInt(icon.id) == 0) {
      return '<span class="post-format-icon post-format-standard"></span> ' + icon.text;
    }

    return '<span class="post-format-icon post-format-'+icon.id+'"></span> ' + icon.text;
  }
  $("#postformat-select").select2({
    formatResult: formatPostFormats,
    formatSelection: formatPostFormats,
    escapeMarkup: function(m) { return m; }
  });

  // Cast & crew
  function hideCastCrewOptions() {
    var selected = $("#cast_or_crew").find("option:selected").text();
    if(selected == "Cast") {
      $("#role").parent().hide();
      $("#character").parent().show();
    } else {
      $("#role").parent().show();
      $("#character").parent().hide();
    }
  }

  $("#cast_or_crew").change(function() {
    hideCastCrewOptions();
  });
  hideCastCrewOptions();

  // Gallery post format
  function hideGalleryOptions() {
    var selected = $("#layout").find("option:selected").text();
    if(selected == "Grid") {
      $("#effect, #autoplay").parent().hide();
      $("#interval").parent().parent().hide();
    } else {
      $("#effect, #autoplay").parent().show();
      $("#interval").parent().parent().show();
    }
  }

  $("#layout").change(function() {
    hideGalleryOptions();
  });
  hideGalleryOptions();

  // Checkboxes
  $("#metabox-t2t_metabox input[type='checkbox'], .rm_section input[type='checkbox']").change(function(){
     if($(this).attr('checked')) {
        $(this).val("true");
     } else {
        $(this).val("false");
     }
  }).trigger("change");

  // Album options
  function hideAlbumOptions() {
    var selected = $("#album_layout_style").find("option:selected").text();
    if(selected == "Grid" || selected == "Masonry") {
      $("#album_photos_per_row, #t2t_album-posts_per_row").parent().show();
	  } else {
	    $("#album_photos_per_row, #t2t_album-posts_per_row").parent().hide();
	  }

    if(selected == "Masonry") {
      $("#masonry_style, #t2t_album-masonry_style").parent().show();
    } else {
      $("#masonry_style, #t2t_album-masonry_style").parent().hide();
    }
  }

  function hideShortcodeAlbumOptions() {
    var selected = $("#t2t_album-album_layout_style").find("option:selected").text();
    if(selected == "Grid" || selected == "Masonry") {
      $("#t2t_album-posts_per_row").parent().show();
    } else {
      $("#t2t_album-posts_per_row").parent().hide();
    }

    if(selected == "Masonry") {
      $("#t2t_album-masonry_style").parent().show();
    } else {
      $("#t2t_album-masonry_style").parent().hide();
    }
  }

  // Pie charts
  $("#pie_chart-legend_style").change(function() {
    var this_val = $("#pie_chart-legend_style option:selected").val();
    if(this_val == "custom_text") {
      $("#pie_chart-icon").parent().hide();
      $("#pie_chart-custom_text").parent().show();
    } else if(this_val == "icon") {
      $("#pie_chart-icon").parent().show();
      $("#pie_chart-custom_text").parent().hide();
    } else {
      $("#pie_chart-icon").parent().hide();
      $("#pie_chart-custom_text").parent().hide();
    }
  }).trigger("change");


	$("#album_layout_style").change(function() {
    hideAlbumOptions();
	});
	hideAlbumOptions();

  $("#t2t_album-album_layout_style").change(function() {
    hideShortcodeAlbumOptions();
  });
  hideShortcodeAlbumOptions();

    // Album options
  function hideMetaAlbumOptions() {
    var selected = $("#t2t_album-album_layout_style").find("option:selected").text();
    if(selected == "Grid" || selected == "Masonry") {
      $("#t2t_album-posts_per_row").parent().show();
    } else {
      $("#t2t_album-posts_per_row").parent().hide();
    }
  }

  $("#t2t_album-album_layout_style").change(function() {
    hideMetaAlbumOptions();
  });
  hideMetaAlbumOptions();

  // Schedule
  $("#t2t_schedule-program_id").change(function() {
    if($(this).find("option:selected").val() === "") {
      $("#t2t_schedule-show_program_filter").parent().show();
    } else {
      $("#t2t_schedule-show_program_filter").parent().hide();
    }
  }).trigger("change");

  // Colorpicker
  $('.t2t-color-picker').wpColorPicker();

  // Section titles
  $("#section_title-style").change(function() {
    $("#section_title-sub_title").attr("disabled", "disabled").parent().hide();
    if($(this).find("option:selected").val() == "with_sub_title") {
      $("#section_title-sub_title").removeAttr("disabled").parent().show();
    }
  }).trigger("change");

  // Sliders
  $(".noUiSlider").each(function() {

    var this_slider = $(this);

    var range = $(this).attr("data-range").split(",");
    var start = $(this).attr("data-start");
    var step = $(this).attr("data-step");

    this_slider.parent().find(".slider_value").text(start);

    $(this).noUiSlider({
        range: [range[0], range[1]],
        start: start,
        step: step,
        handles: 1,
        serialization: { to: [false, false] },
        slide: function(){
          var value = $(this).val();
          this_slider.next("input[type='hidden']").val(value);
          this_slider.parent().find(".slider_value").text(value);
       }
    });
  });

  $("#photo_grid-layout").parent().hide().next("div").hide().next("div").hide();
  $("#div_photo_grid .multi-uploader").removeClass("attr");

  // Meta box uploaders
  $(".t2t-uploader-button").each(function() {
    var custom_uploader;

    $(this).click(function(e) {

      e.preventDefault();

      var this_button = $(this);
      var limit = $(this).attr("data-limit");
      var is_multi = $(this).hasClass("multi-uploader");
      var current_selection = this_button.prev(".t2t-uploader").val();

      // Options for multi vs. single uploads
      if(is_multi) {
        options = {
          title: 'Choose Photos',
          button: {
              text: 'Choose Photos'
          },
          frame: 'select',
          library : {
            type : 'image'
          },
          multiple:  true
        }
      } else {
        if(this_button.hasClass("is_audio")) {
          options = {
            title: 'Choose Audio File',
            button: {
                text: 'Choose Audio File'
            },
            library : {
              type : 'audio'
            },
            multiple: false
          }
        } else if(this_button.hasClass("is_video")) {
          options = {
            title: 'Choose Video File',
            button: {
                text: 'Choose Video File'
            },
            library : {
              type : 'video'
            },
            multiple: false
          }
        } else {
          options = {
            title: 'Choose Photo',
            button: {
                text: 'Choose Photo'
            },
            library : {
              type : 'image'
            },
            multiple: false
          }
        }
      }

      // Extend the wp.media object
      custom_uploader = wp.media.frames.file_frame = wp.media(options);

      // When a file is selected, grab the URL and set it as the text field's value
      custom_uploader.on('close', function() {
        if(is_multi) {

          // Set an emtpy array to store the hidden input value
          var attachment_string = [];

          // Get the selection of images from the uploader
          attachments = custom_uploader.state().get('selection').toJSON();

          // Setup a variable to store the thumbnail markup
          thumbnails = "";

          var count = 0;

          // Set limit
          if(limit) {
            var upload_limit = limit;
          } else {
            var upload_limit = 999999;
          }

          // Loop through selection, append to input value and thumbnail div
          attachments.map(function(attachment) {

            if(count <= upload_limit) {

              // Add to hidden field
              attachment_string.push(attachment.id);

              thumbnails += '<li>';
              if(typeof attachment.sizes != "undefined") {
                thumbnails += '<img src="'+attachment.sizes.thumbnail.url+'">';
              }
              thumbnails += '</li>';

            }

            count++;
          });

          // Set the hidden value and thumbnail markup
          this_button.prev(".t2t-uploader").val(attachment_string.join(","));
          this_button.parent().find('.t2t-gallery-thumbs ul').html(thumbnails);

          // For photo grid shortcode
          if($("#photo_grid-layout").length > 0) {
            var grid_layout = $("#photo_grid-layout");

            if(count >= 3) {

              grid_layout.parent().show().next("div").show().next("div").show();
              grid_layout.find("option").attr("disabled", "disabled");

              if(count == 3) {
                grid_layout.find("option[value='12'], option[value='21']").removeAttr("disabled");
              } else if(count == 4) {
                grid_layout.find("option[value='13'], option[value='22'], option[value='31']").removeAttr("disabled");
              } else if(count == 5) {
                grid_layout.find("option[value='14'], option[value='23'], option[value='32'], option[value='41']").removeAttr("disabled");
              } else if(count == 6) {
                grid_layout.find("option[value='15'], option[value='24'], option[value='33'], option[value='42'], option[value='51']").removeAttr("disabled");
              }

              grid_layout.select2("destroy")
                .select2()
                .select2("val", grid_layout.find("option:not(:disabled)").first().val());

            } else {
              grid_layout.parent().hide().next("div").hide().next("div").hide();
              this_button.prev(".t2t-uploader").val("");
              this_button.parent().find('.t2t-gallery-thumbs ul').html("");
              alert("Please select atleast 3 photos.");
            }
          }

        } else {
          // Set the hidden value
          attachment = custom_uploader.state().get('selection').first().toJSON();
          this_button.prev(".t2t-uploader").val(attachment.url);
        }

      });

      custom_uploader.on('open', function() {
        // Preselect attachements from the hidden input
        var selection = custom_uploader.state().get('selection');
        ids = current_selection.split(',');

        ids.forEach(function(id) {
          attachment = wp.media.attachment(id);
          attachment.fetch();
          selection.add(attachment ? [ attachment ] : []);
        });
      });

      // Open the uploader dialog
      custom_uploader.open();

    });
  });

  // Albums
  if($(".t2t-gallery-thumbs ul li").length > 0) {
    $("#t2t_gallery_button").val("Edit Photos").removeClass('button-primary');
  } else {
    $("#t2t_gallery_button").val("Add Photos").addClass('button-primary');
  }

  var gallery_thumbs = $("#postformat_metabox .t2t-gallery-thumbs ul, #gallery_metabox .t2t-gallery-thumbs ul");

  function loadImages(images) {
   if(images) {

     var shortcode = new wp.shortcode({
       tag:    "gallery",
       attrs:  { ids: images },
       type:   "single"
     });
     var attachments = wp.media.gallery.attachments( shortcode );
     var selection = new wp.media.model.Selection( attachments.models, {
       props:    attachments.props.toJSON(),
       multiple: true
     });
     selection.gallery = attachments.gallery;

     selection.more().done( function() {
       // Break ties with the query.
       selection.props.set({ query: false });
       selection.unmirror();
       selection.props.unset("orderby");
     });

     return selection;
   }

   return false;
  }

  selection = loadImages(gallery_thumbs.attr("data-images"));

  $('#t2t_gallery_button').on('click', function() {
    var button = $(this);

    options = {
      frame:     'post',
      state:     'gallery-edit',
      title:     wp.media.view.l10n.editGalleryTitle,
      editing:   true,
      multiple:  true,
      selection: selection
    }
    frame = wp.media(options).open();

    // Tweak views
    frame.menu.get('view').unset('cancel');
    frame.menu.get('view').unset('separateCancel');
    frame.menu.get('view').get('gallery-edit').el.innerHTML = 'Edit Photos';
    frame.menu.get('view').get('gallery-library').el.innerHTML = 'Add Photos';
    frame.title.get('view').el.innerHTML = 'Edit Photos';
    frame.content.get('view').sidebar.unset('gallery'); // Hide Gallery Settings in sidebar

    // Override insert button
    function overrideGalleryInsert() {
      frame.toolbar.get('view').set({
        insert: {
          style: 'primary',
          text: 'Add Photos →',
          click: function() {

            var models = frame.state().get('library');
            var ids = new Array();
            var thumbnails = "";

            models.each(function(attachment) {
              if(attachment.attributes.sizes.thumbnail !== undefined){
                ids.push(attachment.id);

                thumbnails += '<li>';
                thumbnails += '<img src="'+attachment.attributes.sizes.thumbnail.url+'">';
                thumbnails += '<input type="hidden" name="gallery_image_ids[]" value="'+attachment.id+'" />';
                thumbnails += '</li>';
              }
            });

            this.el.innerHTML = 'Saving...';

            gallery_thumbs.html(thumbnails);

            selection = loadImages(ids.join());

            if(gallery_thumbs.find("li").length > 0) {
              $("#t2t_gallery_button").val("Edit Photos").removeClass('button-primary');
            } else {
              $("#t2t_gallery_button").val("Add Photos").addClass('button-primary');
            }
            frame.close();
          }
        }
      });
    }
    overrideGalleryInsert();

    frame.on( 'toolbar:render:gallery-edit', function() {
       overrideGalleryInsert();
    });
  });

  // method to determine which metaboxes to show
  function checkPageTemplate() {

    var all_templates = $("#page_template").find("option");

    for(var i = 0; i < all_templates.length; i++) {
      var this_template = $(all_templates[i]).val();

      if(this_template != "default") {
        $("#" + this_template.slice(0, -4)).hide();
        $("#" + this_template.slice(0, -4)).find("input, textarea").attr("disabled", "disabled")
          .end().find("select").select2("enable", false);
      }
    }

    // selected template
    var current_post_type = $("select#page_template :selected").val();

    if(typeof current_post_type != "undefined") {
      // strip the file extension to match our id naming conventions
      $("#" + current_post_type.slice(0, -4)).show();
      $("#" + current_post_type.slice(0, -4)).find("input, textarea").removeAttr("disabled")
        .end().find("select").select2("enable", true);
    }
  }

  checkPageTemplate();

  // temlate selector
  $("select#page_template").change(function () {
    checkPageTemplate();
  });
});