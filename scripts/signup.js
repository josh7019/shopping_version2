    let isAccountRight = true;
    let isPasswordRight = false;
    let isPasswordTwice = false;
    let isIdNumberRight = false;
    let isNameRight = false;

window.onload=function(){

    let account_input = document.getElementById('account');
    let password_input = document.getElementById('password');
    let passwordTwice_input = document.getElementById('passwordTwice');
    let name = document.getElementById('name');
    let id_number = document.getElementById('id_number');
    let login_button = document.getElementById('login_button');

    passwordTwice_input.oninput = function(event){confirmPassword(event)}
    account_input.oninput = function(event){checkAccountFormat(event)};
    password_input.oninput = function(event){checkPassword(event)};
    id_number.oninput = function(event){checkIdNumber(event)};
    name.oninput = function(event){checkName(event)};
    login_button.onclick=function(){return false;};

}


// 格式驗證正確後submit才能激活
function isSubmit(){
    if (isAccountRight && isPasswordRight && isPasswordTwice && isIdNumberRight && isNameRight) {
        login_button.onclick = function(){submitSignup()};
    } else {
        login_button.onclick=function(){alert(isAccountRight + ""+ isPasswordRight + isPasswordTwice + isIdNumberRight + isNameRight);return false;};
    }
}

// 檢查身分證
function checkIdNumber(e){
    id = e.target.value.toUpperCase();
    isIdNumberRight = checkIdNumberFormat(id);
    if (isIdNumberRight) {
        document.getElementById('id_number_Signal').innerText='ok';
    } else {
        document.getElementById('id_number_Signal').innerText='錯誤';
    }
    isSubmit();
}

// 檢查姓名
function checkName(e){
    name = e.target.value;
    isNameRight = checkNameFormat(name);
    if (isNameRight) {
        document.getElementById('name_Signal').innerText='ok';
    } else {
        document.getElementById('name_Signal').innerText='錯誤';
    }
    isSubmit();
}

// 檢查帳號格式與資料庫有無相同帳號 
function checkAccountFormat(e){
    if(checkFormat(e.target.value)){
        // ajax 到後端檢查帳號是否存在
        $.ajax({
            type:'post',
            url:'/shopping/controller/UserController.php/checkAccount',
            data:{
                account:e.target.value,
                action:'checkAccount',
            },
            success:function(user_account){
                console.log(user_account);
                user_account = JSON.parse(user_account)
                if(user_account['account']){
                    isAccountRight=false;
                    $('#account_Signal').html('已有相同帳號');
                }else{
                    $('#account_Signal').html('ok');
                    isAccountRight=true;
                    isSubmit();
                }
            }
        })
    }else{
        $('#account_Signal').html('x');
        isAccountRight=false;
    }
    isSubmit();
}

// 檢查密碼格式
function checkPassword(e) {
    if(checkPasswordFormat(e.target.value)){
        isPasswordRight=true;
        isPasswordTwice=false;
        $('#password_Signal').html('ok');
        $('#passwordTwice_Signal').html('密碼不相同');
    }else{
        isPasswordRight=false;
        isPasswordTwice=false;
        $('#passwordTwice_Signal').html('密碼不相同');
        $('#password_Signal').html('格式錯誤');
    }
    isSubmit();
}

// 二次驗證輸入密碼
function confirmPassword (e) {
    let password='';
    password=$('#password').val();
    if(e.target.value==password){
        isPasswordTwice=true;
        $('#passwordTwice_Signal').html('ok');
    }else{
        isPasswordTwice=false;
        $('#passwordTwice_Signal').html('密碼不相同');
    }
    isSubmit();
}

// 送出註冊表單
function submitSignup(){
    let data = {
        action : 'signup',
        account : $('#account').val(),
        password : $('#password').val(),
        name : $('#name').val(),
        id_number : $('#id_number').val().toUpperCase(),
    };
    $.ajax({
        type : 'post',
        url : '/shopping/controller/UserController.php/signup',
        data : data,
        success : function (result_array) {
            // console.log(result_array);
            result_array = JSON.parse(result_array);
            // console.log(result_array);
            showSingal(result_array['alert']);
            direct(result_array['location']);
        }
    })
}



