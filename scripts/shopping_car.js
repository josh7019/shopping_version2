

window.onload = function () {
    button_element_list = document.getElementsByClassName('delete_button');
    for (let i = 0; i < button_element_list.length; i++) {
        button_element_list[i].onclick = function (e) {
            row = e.target.parentElement.parentElement.parentElement;
            product_id = row.children[0].value;
            deleteOne();
        }
    }

    amount_element_list = document.getElementsByClassName('amount');
    for (let i = 0; i < amount_element_list.length; i++) {
        amount_element_list[i].onblur = function (e) {
            row = e.target.parentElement.parentElement;
            product_id = row.children[0].value;
            amount = e.target.value;
            changeAmount()
        }
    }

}

function deleteOne() {
    if(!confirm('確定移除商品嗎?')){
        return ;
    }
    $.ajax({
        type : 'DELETE',
        url : '/shopping/controller/usercontroller.php/product',
        data : {'product_id' : product_id},
        success : function(result_array) {
            // console.log(result_array);
            result_array = JSON.parse(result_array);
            showSingal(result_array['alert']);
            if (result_array['is_success']) {
                row.style.display = 'none';
            }
        }
    })
}

function changeAmount() {
    $.ajax({
        type : 'PUT',
        url : '/shopping/controller/usercontroller.php/product',
        data : {
            'product_id' : product_id,
            'amount' : amount
        },
        success : function(result_array) {
            console.log(result_array);
            result_array = JSON.parse(result_array);
            showSingal(result_array['alert']);
        }
    })
}