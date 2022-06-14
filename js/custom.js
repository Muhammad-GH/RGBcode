//This function loads the users table onload
window.onload = function() {
    if (document.body.classList.contains('logged-in')) {
        load_data();
    }

};


//Sorting table by click on the header arrows
function sortdatanew(column, type) {
   
    sessionStorage.setItem("column", column);
    sessionStorage.setItem("type", type);
    var page = $(this).attr("id");
    var role = $('#roleid').val();
    load_data(page, role);

}

//Global Variables
var setsortvalue = "";
var direction = "asc"
var direction2 = "";
//This function is calling ajax function
function load_data(page, role) {



    var column = ""
    var type = "";
    if (sessionStorage.getItem("column")) {
        column = sessionStorage.getItem("column")
        type = sessionStorage.getItem("type")
    }


    var data = {
        page: page,
        action: "pagination",
        role: role,
        column: column,
        type: type
    }
    var TemplateUrl = object_name.TemplateUrl;
    $.ajax({
        url: TemplateUrl + '/ajaxdata.php',
        method: "POST",
        data: data,
        success: function(data) {
            $("#pagination_data").html(data);
        }
    })

}

//  Pagination function

function test(i){
   
    var page = i;
    var role = $('#roleid').val();
 
    if (role!= '') {
       
        load_data(page, role);

    } else {
       
        load_data(page);

    }
}

 $('.pagination_link').click(function(clickEvent) {
    

});