// set the alt options for each date picker

jQuery(document).ready(function() {
	// define datepicker defaults
	jQuery(".t2t_datepicker").datepicker({
		showButtonPanel: true,
		closeText:       objectL10n.closeText,
		currentText:     objectL10n.currentText,
		monthNames:      objectL10n.monthNames,
		monthNamesShort: objectL10n.monthNamesShort,
		dayNames:        objectL10n.dayNames,
		dayNamesShort:   objectL10n.dayNamesShort,
		dayNamesMin:     objectL10n.dayNamesMin,
		firstDay:        objectL10n.firstDay,
		isRTL:           objectL10n.isRTL,
		showOn:          "button",
    buttonImage:     t2t_toolkit_path+"images/calendar.png",
    buttonImageOnly: true,
    altFormat:       objectL10n.altFormat,
    dateFormat:      "yy-mm-dd"
	});

	jQuery(".t2t_datepicker").each(function() {
		jQuery(this).datepicker("option", "altField", "#" + jQuery(this).attr("id") + "_alt");
	});
});