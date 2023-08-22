function getresult(url) {
    $('#loader-icon').show();
    $.ajax({
        url: url,
        type: "GET",
        data: { rowcount: $("#rowcount").val() },
        success: function(data) {
           console.log(data);
        },
        error: function() { }
    });
}

