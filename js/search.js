$(document).ready(function () {
  // Send Search Text to the server
  
  $("#search").keyup(function () {
    

    let searchText = $(this).val();
    if (searchText != "") {
      console.log(searchText);
      $.ajax({
        url: 'handleRequests.php',
        type: 'POST',
        data: {query: searchText},
        async: false,
        error: function(xhr, status, error) {
          console.log(error)
        },
        success: function (response) {

          //$("#show-list").html(response);

        },
      });
    } else {
      $("#show-list").html("");
    }
  });
  // Set searched text in input field on click of search button
  $(document).on("click", "a", function () {
    $("#search").val($(this).text());
    $("#show-list").html("");
  });
});
