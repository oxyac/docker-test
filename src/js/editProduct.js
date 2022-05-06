function editSend(id) {
    let obj = {
        id: id,
        name: $('#ein'+id+'').val()
    }
    $.ajax({
        type: "POST",
        url: "db/editProduct.php",
        data: obj,
        success: function (res) {
            loadData();
        }
    });
}