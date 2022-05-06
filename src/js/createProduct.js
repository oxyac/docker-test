// ################################################################
    function create() {
        let obj = {
            name : $('#in_in').val()
        };
        $.ajax({
        type: "POST",
        url: "db/addProduct.php",
        data: obj,
        success: function (res) {
            loadData();
            $('#in_in').val("");
        }
    });
    }