let add_product;
let add_button;
let price;
let name;
let descript;
let is_price_right;
let is_name_right;
let is_descript_right;
let is_stock_right;

window.onload = function(){
    add_product = document.getElementById('add_product');
    add_button = document.getElementById('add_button');
    price = document.getElementById('price');
    name = document.getElementById('name');
    descript = document.getElementById('descript');
    stock = document.getElementById('stock');

    descript.oninput = function(event) {checkDescript(event);}
    price.oninput = function(event) {checkPrice(event);}
    name.oninput = function(event) {checkName(event);}
    stock.oninput = function(event) {checkStock(event);}
    add_button.onclick = function() {alert('not yet'); return false;}
}


function checkPrice(e){
    price = e.target.value;
    
    if (!price.match(/^[1-9][0-9]{0,}$/)) {
        document.getElementById('price_signal').innerHTML = 'x';
        issubmit()
        is_price_right = false;
    } else {
        document.getElementById('price_signal').innerHTML = 'o';
        issubmit()
        is_price_right = true;
    }
    
}

function checkStock(e){
    price = e.target.value;
    
    if (!price.match(/^[1-9][0-9]{0,}$/)) {
        document.getElementById('stock_signal').innerHTML = 'x';
        issubmit()
        is_stock_right = false;
    } else {
        document.getElementById('stock_signal').innerHTML = 'o';
        issubmit()
        is_stock_right = true;
    }
    
}

function checkName(e){
    product_name = e.target.value;
    is_name_right = checkContent(product_name);
    
    if (is_name_right) {
        document.getElementById('name_signal').innerHTML = 'o';
    } else {
        document.getElementById('name_signal').innerHTML = 'x';
    }
    issubmit();
}


function checkDescript(e){
    product_descript = e.target.value;
    is_descript_right = checkContent(product_descript);
    if (is_descript_right) {
        document.getElementById('descript_signal').innerHTML = 'o';
    } else {
        document.getElementById('descript_signal').innerHTML = 'x';
    }
    issubmit();
}


function issubmit(){
    if (is_price_right && is_name_right && is_descript_right && is_stock_right) {
        add_button.onclick = function(){submit();};
    } else {
        add_button.onclick = function(){alert('格式有誤')};
        
    }
}


function submit(){
    var formData=new FormData(add_product);
    console.log(formData);
    // formData.append('img',$('#file')[0].files[0])
    // formData.append("code",$("#code").val())
    $.ajax({
            url:'/shopping/Controller/ManagerController.php/addProduct',
            type:'post',
            dataType:'text',
            cache: false,
            processData: false,
            contentType: false,
            data:formData,
            success:function(result_array){  
                console.log(result_array);
                result_array = JSON.parse(result_array);
                console.log(result_array);
                showSingal(result_array['alert']);
                direct(result_array['location']);
            },
            error:function(){
            console.log("上傳失敗")
            }
        })
    }




