function lookup(input_2) {
    if(input_2.length == 0) {
        // Hide the suggestion box.
        $('#suggestions').hide();
    } else {
         $.post("rpc.php", {queryString: "121212"}, function(data){
            if(data.length >0) {
                $('#suggestions').show();
                $('#autoSuggestionsList').html(data);
            }
        });
    }
} // lookup

function fill(thisValue) {
    $('#input_2').val(thisValue);
   $('#suggestions').hide();
}