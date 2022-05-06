$(document).ready(function () {
        loadData();
    });

// #############################################
    function loadData() {
        $.ajax({
        type: "GET",
        url: "db/getAllProducts.php",
        success: function (res) {

            res = JSON.parse(res);

            var result = "";
            for(let i = 0; i < res.length; i++) {
                result += "<tr>"
                result += "<td>" + res[i].id + "</td>";
                result += "<td>" + res[i].name + "</td>";
                result += "<td><button>Edit</button></td>";
                result += "<td><button onclick='del(" + res[i].id + ")'>Delete</button></td>";
                result += "</tr>";
            }
            $("#data_display tbody").html(result);
        }
    });
    }
    