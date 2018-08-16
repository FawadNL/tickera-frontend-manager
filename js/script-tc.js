jQuery(document).ready(function(){

 jQuery('#wp-tc_content_editor-wrap').insertAfter('#content_editor');
 jQuery('#wp-tc_term_editor-wrap').insertAfter('#term_editor');
 
 jQuery('#event_end_time').timepicker({ 'timeFormat': 'H:i','step': 10 });
 jQuery('#event_start_time').timepicker({ 'timeFormat': 'H:i','step': 10 });
 
 jQuery('#event_start').datepicker({ dateFormat: 'yy-mm-dd', minDate: 0 });
 jQuery('#event_end').datepicker({ dateFormat: 'yy-mm-dd', minDate: 0 });
 });
 
 var above_id = '';
 
 jQuery(document).ready(function() {
 
 
 
 jQuery('#upload').click(function(e) {
  e.preventDefault();
  var custom_uploader = '';
   if (custom_uploader) {
   custom_uploader.open();
   return;
  }
   
  target_input = jQuery(this).attr('rel');
  
  custom_uploader = wp.media.frames.file_frame = wp.media({
   title: 'Choose Image',
   button: {
    text: 'Choose Image'
   },
   multiple: false
  });
   
  custom_uploader.on('select', function() {
   attachment = custom_uploader.state().get('selection').first().toJSON();
   jQuery('input[name=' + target_input + ']').val(attachment.url);
 
  });
 
 custom_uploader.open();
 });
 jQuery('#upload1').click(function(e) {
  e.preventDefault();
  var custom_uploader = '';
   if (custom_uploader) {
   custom_uploader.open();
   return;
  }
   
  target_input = jQuery(this).attr('rel');
 
  
  custom_uploader = wp.media.frames.file_frame = wp.media({
   title: 'Choose Image',
   button: {
    text: 'Choose Image'
   },
   multiple: false
  });
   
  custom_uploader.on('select', function() {
   attachment = custom_uploader.state().get('selection').first().toJSON();
   jQuery('input[name=' + target_input + ']').val(attachment.url);
 
  });
 
 custom_uploader.open();
 });
 jQuery('#upload2').click(function(e) {
  e.preventDefault();
  var custom_uploader = '';
   if (custom_uploader) {
   custom_uploader.open();
   return;
  }
   
  target_input = jQuery(this).attr('rel');
  target_id = jQuery(this).attr('data');
  
  custom_uploader = wp.media.frames.file_frame = wp.media({
   title: 'Choose Image',
   button: {
    text: 'Choose Image'
   },
   multiple: false
  });
   
  custom_uploader.on('select', function() {
   attachment = custom_uploader.state().get('selection').first().toJSON();
   jQuery('input[name=' + target_input + ']').val(attachment.url);
   jQuery('input[name=' + target_id + ']').val(attachment.id);
  });
 
 custom_uploader.open();
 });
 });