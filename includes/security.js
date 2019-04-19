$(function() {
    var query;
    var parent;

    $("#check").on("click keydown", function (e) {

        e.preventDefault();

        query = document.getElementById("query");
        queryString = query.value;
        parent = document.getElementById("parent");
        var statusBox = document.createElement('div');
        statusBox.className = 'statusBox';


        request = $.ajax({
            type: "get",
            url: "sendResponse.php",
            data: {
                website: queryString
            }
        });
        request.done(function (response) {
         //   alert(response);
            query.value = "";

            statusBox.innerHTML = response;
        //    parent.appendChild(statusBox);
            parent.insertBefore(statusBox, parent.firstChild)


        });

        request.fail(function (jqXHR, textStatus) {
            alert("Request failed: " + textStatus);
        });

    });

    $('#query').keypress(function(e){
        if(e.which == 13){//Enter key pressed
            $('#check').click();//Trigger search button click event
        }
    });

});






