window.onload = function(){
    button_list = document.getElementsByClassName('delete_button');
    for (let i = 0; i < button_list.length; i++) {
        button_list[i].onclick = function(e){
            alert(e.target.parentElement.parentElement.parentElement.children[0].innerText);
        }
    }
    
}
