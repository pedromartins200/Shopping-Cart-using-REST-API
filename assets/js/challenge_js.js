function showCartModal() {
    $('#cartModal').modal('show');
    return false;
}


//not used
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

function addFiscalInfo() {
    $('#modal_fiscal_info').modal('show');
}


//ok isto funciona mas n vale a pena perder tempo com mariquices
//posso fazer diretamente por php e carrego tudo na pagina
function showOrderItems(user_id, api_key, order_id, base_url) {

    var item_status = document.getElementById('show_items'+order_id).value;
    if(item_status == "Show Items") {
        $.ajax({
            type: 'GET',
            url: controller_url + '/api/Order/' + user_id + '/' + api_key + '/' + order_id,

            success: function (order) {
                //get order items tr
                var string = '';
                string += "<div class='container'>";
                string += "<table class='table' cellpadding='10' cellspacing='1'>";
                string += "<tbody>";
                string += "<tr>";
                string += "<th style='text-align:left;'>Name</th>";
                string += "<th style='text-align:left;'>Category</th>";
                string += "<th style='text-align:left;' width='10%'>Quantity</th>";
                string += "<th style='text-align:left;' width='15%'>Price</th>";
                string += "</tr>";
                for(var i = 0; i < order.length; i++) {
                    string += "<tr>";
                    string += "<td>";
                    var img_src = base_url + order[i].image;
                    string += "<img class='cart-item-image' src=" + img_src + ">" + order[i].name;
                    string += "</td>";
                    string += "<td>";
                    string += order[i].category_name;
                    string += "</td>";
                    string += "<td>";
                    string += order[i].quantity;
                    string += "</td>";
                    string += "<td>";
                    string += order[i].price + " * ("+ order[i].quantity +")";
                    string += "</td>";
                    string += "</tr>";
                }


                string += "</table>";
                string += "</div>";

                document.getElementById('order_items'+order_id).innerHTML = string;
                document.getElementById('order_items'+order_id).className = 'd-block';

                document.getElementById('show_items'+order_id).value = "Hide Items";

                document.getElementById('show_items'+order_id).className = 'btn btn-danger';

            },
            error: function (msg) {
                alert('coco');
            }
        });
    } else {
        document.getElementById('order_items'+order_id).innerHTML = '';
        document.getElementById('order_items'+order_id).className = 'd-none';

        document.getElementById('show_items'+order_id).value = "Show Items";

        document.getElementById('show_items'+order_id).className = 'btn btn-primary';
    }

}


function hideOrderItems()
{

}