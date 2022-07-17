
jQuery(function() {
    jQuery('input[name="daterange"]').daterangepicker({
    opens: 'left'
  }, function(start, end) {
    console.log("A new date selection was made:"+ start.format('MM-DD-YYYY')+'to'+end.format('MM-DD-YYYY'));
  });
});
