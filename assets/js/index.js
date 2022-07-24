var daterange;
var rangeDateDefault = new Date();
var rangeDateStart;
var rangeDateEnd;

if(daterange) {
  var start = daterange.split('-')[0].trim();
  var end = daterange.split('-')[1].trim();

  rangeDateStart = new Date(start);
  rangeDateEnd = new Date(end);
}
else {
  rangeDateStart = new Date(rangeDateDefault.setDate("1"));
  rangeDateEnd = new Date(rangeDateDefault.setMonth(rangeDateDefault.getMonth() + 1));
}

console.log(daterange, rangeDateStart, rangeDateEnd);

function changeDate(start, end) {
  $('input[name="daterange"]').val(start.format("DD/MM/YYYY") + " - " + end.format("DD/MM/YYYY"));
}

jQuery(function() {
    jQuery('input[name="daterange"]').daterangepicker({
        // singleDatePicker: true,
        startDate: rangeDateStart,
        endDate: rangeDateEnd,
      }, changeDate);
});
