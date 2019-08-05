window.onload = function(){
    
    update_permission();
}


function update_permission(){
    let button_list = document.getElementsByClassName('update_button');
    for (let i = 0; i < button_list.length; i++) {
        button_list[i].onclick = function(e){
            let row = e.target.parentElement.parentElement.parentElement;
            let user_id = row.children[0].innerText;
            let permission = row.children[3].children[0].value;
            if(confirm('確定修改嗎?')){
                $.ajax({
                    type : 'PUT',
                    url : '/shopping/controller/managercontroller.php/member',
                    data : {'user_id' : user_id, 'permission' : permission},
                    success : function (result_array){
                        // console.log(result_array);
                        result_array = JSON.parse(result_array);
                        showSingal(result_array['alert']);
                    }
                })
            }
        }
    }
}