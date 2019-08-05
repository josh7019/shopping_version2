let isAccountRight = true;
let isPasswordRight = false;
let account_input;
let password_input;
let login_button;

window.onload=function(){
    account_input = document.getElementById('account');
    password_input = document.getElementById('password');
    login_button = document.getElementById('login_button');

    account_input.oninput = function(event){checkAccountFormat(event)};
    password_input.oninput = function(event){checkPassword(event)};
    login_button.onclick = function(){alert('帳號或密碼格式錯誤')};
}

function checkAccountFormat(e)
{
    isAccountRight = (checkFormat(e.target.value)) ? true : false;
    isSubmit();
}
function checkPassword(e)
{
    isPasswordRight = (checkPasswordFormat(e.target.value)) ? true : false;
    isSubmit();
}

// 格式驗證正確後submit才能激活
function isSubmit() {
    if(isAccountRight && isPasswordRight){
        login_button.onclick = function(){login();};
    } else {
        login_button.onclick = function(){alert('帳號或密碼格式錯誤')};
    }
}

// 送出登入表單
function login() 
{
    let data = {
        'account' : account_input.value,
        'password' : password_input.value,
        'action' : 'login'
    }
    $.ajax({
        type : 'post',
        url : '../controller/ManagerController.php/login',
        data : data,
        success : function (result_array) {
            console.log(result_array);
            result_array = JSON.parse(result_array);
            showSingal(result_array['alert']);
            direct(result_array['location']);
        }
    })
}
