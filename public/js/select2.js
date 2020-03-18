$(document).ready(function() {
    $('.select2').select2();
});
function matchStart(params, data) {
  // If there are no search terms, return all of the data
  if ($.trim(params.term) === '') {
    return data;
  }

  // Return `null` if the term should not be displayed
  return null;
}

$(".js-example-matcher-start").select2({
  matcher: matchStart
});