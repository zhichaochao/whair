jQuery(document).ready(function(){
    jQuery("input.numbersOnly").keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if (jQuery.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
             // Allow: Ctrl+A
            (e.keyCode == 65 && e.ctrlKey === true) || 
             // Allow: home, end, left, right
            (e.keyCode >= 35 && e.keyCode <= 39)) {
                 // let it happen, don't do anything
                 return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });
});

jQuery( document ).ready(function() {

  jQuery('input[type="checkbox"]').each(function(){
    if (!jQuery(this).hasClass('ios-switch'))
      jQuery(this).wrap('<div class="custom_checkbox"></div>');
  });

  jQuery('div.custom_checkbox').on('click', function(){

    if (!jQuery(this).children('input[type="checkbox"]').attr('disabled'))
    {
      var checked = jQuery(this).children('input[type="checkbox"]').is(':checked');

      if (checked)
      {
        jQuery(this).children('input[type="checkbox"]').prop('checked', false);
        jQuery(this).removeClass('active');
      }
      else
      {
        jQuery(this).children('input[type="checkbox"]').prop('checked', true);
        jQuery(this).addClass('active');
      }
    }
  });

  jQuery('div.custom_checkbox').each(function(){
    if (!jQuery(this).children('input[type="checkbox"]').attr('disabled'))
    {
      var checked = jQuery(this).children('input[type="checkbox"]').is(':checked');
      if (checked)
      {
        jQuery(this).addClass('active');
        jQuery(this).children('input[type="checkbox"]').prop('checked', true);
      }
      else
      {
        jQuery(this).removeClass('active');
        jQuery(this).children('input[type="checkbox"]').prop('checked', false);
      }
    } 
    else
    {
      jQuery(this).addClass('disabled');
    }
  });
});