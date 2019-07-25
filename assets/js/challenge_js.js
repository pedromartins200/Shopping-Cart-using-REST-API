function showCartModal() {
    $('#cartModal').modal('show');
    return false;
}

function add_quantity_to_form(id) {
    var input = document.getElementById("add_quantity_by_input" + id);
    var select = document.getElementById("quantity_select" + id);
    var form = document.getElementById("update_quantity_form");
    if(input.style.display === "") {
        form.action = form.action + "index.php/Cart/cart_item_update/" + id + "/" + input.value;
    } else {
        var select = document.getElementById("quantity_select" + id);
        if(select.options[select.selectedIndex].value === "10+") {
            var input2 = document.getElementById("quantity_more_input" + id);
            form.action = form.action + "index.php/Cart/cart_item_update/" + id + "/" + input2.value;
        } else {
            form.action = form.action + "index.php/Cart/cart_item_update/" + id + "/" + select.options[select.selectedIndex].value;
        }
    }
    //console.log(form.action);
    form.submit();
}
