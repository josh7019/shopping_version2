

window.onload = function(){
    let element_list = document.getElementsByClassName('add_button');
    for(let i = 0; i < element_list.length; i++){
        element_list[i].onclick = function(e) {
            let product_id = e.target.parentElement.children[0].value;
            addProduct(product_id);
        }
        
    }
}


function addProduct(product_id) {
    $.ajax({
        type : 'POST',
        url : '/shopping/controller/usercontroller.php/addproduct',
        data : {'product_id' : product_id},
        success : function (result_array) {
            result_array = JSON.parse(result_array);
            showSingal(result_array['alert']);
            direct(result_array['location']);
            if (result_array['is_success'] == 1) {
                let product_count = document.getElementById('product_count').innerText;
                product_count = parseInt(product_count) + 1;
                document.getElementById('product_count').innerText = product_count;
            }
        }
    })
}