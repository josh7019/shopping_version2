window.onload = function(){
    
    delete_product();
}


function delete_product(){
    let button_list = document.getElementsByClassName('delete_button');
    for (let i = 0; i < button_list.length; i++) {
        button_list[i].onclick = function(e){
            let row = e.target.parentElement.parentElement.parentElement;
            let product_id = row.children[0].innerText;
            if(confirm('確定刪除嗎?')){
                $.ajax({
                    type : 'DELETE',
                    url : '/shopping/controller/managercontroller.php/product',
                    data : {'product_id' : product_id},
                    success : function (result_array){
                        result_array = JSON.parse(result_array);
                        row.style.display = (result_array['is_success']) ? 'none' : 'block';
                        showSingal(result_array['alert']);
                    }
                })
            }
        }
    }
}
