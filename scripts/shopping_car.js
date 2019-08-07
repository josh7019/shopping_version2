

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
            if(!checkUnsigned(amount)) {
                alert('不得為負或小數');
                return ;
            }
            changeAmount(e)
        }
    }
    checkout_button = document.getElementById('checkout_button');
    checkout_button.onclick = function() {checkout();}
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
                document.getElementById('total_price').innerHTML = 'NT' + result_array['total_price'];
                if (result_array['user_final_cash'] >= 0) {
                    document.getElementById('user_final_cash').innerHTML = result_array['user_final_cash'];
                } else {
                    document.getElementById('user_final_cash').innerHTML = result_array['user_final_cash'] + "(餘額不足)";
                }
            } else {
                row.style.display = 'none';
            }
        }
    })
}

function changeAmount(e) {
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
            if (result_array['is_success'] == 1) {
                document.getElementById('total_price').innerHTML = 'NT' + result_array['total_price'];
                if (result_array['user_final_cash'] >= 0) {
                    document.getElementById('user_final_cash').innerHTML = result_array['user_final_cash'];
                } else {
                    document.getElementById('user_final_cash').innerHTML = result_array['user_final_cash'] + "(餘額不足)";
                }
            } else if (result_array['is_success'] == 2) {
                row.style.display = 'none';
            } else if (result_array['is_success'] == 3) {
                e.target.value = result_array['amount']
            }

        }
    })
}

function checkout() {
    $.ajax({
        type : 'UPDATE',
        url : '/shopping/controller/usercontroller.php/checkOut',
        success : function(result_array) {
            console.log(result_array);
            result_array = JSON.parse(result_array);
            showSingal(result_array['alert']);
            direct(result_array['location']);
            
        }
    })
}