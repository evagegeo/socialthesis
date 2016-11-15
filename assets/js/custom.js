$(function(){
    
    /* Datepicker */
    $.datepicker.setDefaults($.extend({dateFormat: 'yy-mm-dd', numberOfMonths: 2}));
    $('.isdatepicker').datepicker();
    
    /* Hide on click */
    $('.hideme').click(function(){$(this).hide();})
    
    /* Initialize Uniform, form styling */
    $('select').uniform();
    $('input:checkbox').uniform();
    $('input:radio').uniform();
    $('input:file').uniform();

    /* Tipsy */
    $('.tipt').tipsy({fade: true, gravity: 's'});
	$('.tipr').tipsy({fade: true, gravity: 'w'});
	$('.tipb').tipsy({fade: true, gravity: 'n'});
	$('.tipl').tipsy({fade: true, gravity: 'e'});

    /* Tabs */
    $('.content-tabs li a').click(function(){
        tabs($(this));

        return false;
    });
    
    /* Initialize cle editor */
    $(".iseditor").cleditor({
          width:        '500px',
          height:       '300px',
          controls:     "bold italic underline strikethrough | alignleft center alignright justify | style color removeformat | bullets numbering | " +
                        "undo redo | rule image link unlink | cut copy paste pastetext | source",
          colors:       "FFF FCC FC9 FF9 FFC 9F9 9FF CFF CCF FCF " +
                        "CCC F66 F96 FF6 FF3 6F9 3FF 6FF 99F F9F " +
                        "BBB F00 F90 FC6 FF0 3F3 6CC 3CF 66C C6C " +
                        "999 C00 F60 FC3 FC0 3C0 0CC 36F 63F C3C " +
                        "666 900 C60 C93 990 090 399 33F 60C 939 " +
                        "333 600 930 963 660 060 366 009 339 636 " +
                        "000 300 630 633 330 030 033 006 309 303",    
          styles:       [["Paragraph", "<p>"], ["Header 4","<h4>"],  ["Header 5","<h5>"], ["Header 6","<h6>"]],
          useCSS:       false,
          docType:      '<!DOCTYPE html>',
          docCSSFile:   "", 
          bodyStyle:    "margin:4px; font:10pt Arial,Verdana; cursor:text"
    });
});

/*
 * function tabs(tab)
 *
 * Switch tabs
 *
 * Adds the class active to the new clicked link and only shows the selected tab
 *
 */
function tabs(tab)
{
    $('.content-tabs li a').removeClass("active");
    tab.addClass("active");

	$('.istab').hide();
	$('#' + tab.attr("rel")).show();
}