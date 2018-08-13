jQuery(document).ready(function(){
    
jQuery('#wp-tc_content_editor-wrap').insertAfter('#content_editor');
jQuery('#wp-tc_term_editor-wrap').insertAfter('#term_editor');

jQuery('#event_end_time').timepicker({ 'timeFormat': 'H:i','step': 10 });
jQuery('#event_start_time').timepicker({ 'timeFormat': 'H:i','step': 10 });

jQuery('#event_start').datepicker({ dateFormat: 'yy-mm-dd', minDate: 0 });
jQuery('#event_end').datepicker({ dateFormat: 'yy-mm-dd', minDate: 0 });
});