function del(id) {
        $.ajax({
        type: "DELETE",
        url: "db/deleteProduct.php?id=" + id,
        success: function (res) {
            loadData();
        }
    });
}