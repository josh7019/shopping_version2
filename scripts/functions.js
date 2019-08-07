// 取得現在時間
function nowtime(){
    var now=new Date().getFullYear() + "-" + (new Date().getMonth() + 1) + "-" + new Date().getDate() +
    " " + new Date().getHours() + ":" + new Date().getMinutes() + ":" + new Date().getSeconds();
    return now;
}

// 檢查帳號格式
function checkFormat(str){
    if (str.match(/^[a-zA-Z][a-zA-Z0-9]{6,20}$/)) {
        return true;  
    } else {    
        return false;
    }
}

// 檢查密碼格式
function checkPasswordFormat(str){
    if (str.match(/^[a-zA-Z0-9]{4,20}$/)) {
        return true; 
    } else {    
        return false;
    }
}

// 檢查身分證號碼格式

function checkIdNumberFormat(id){
    let patt=/^[A-Z][12]\d{8}$/g;
    let isright=patt.test(id);
    let result=id.match(patt);

    if(result!=null){
        let letters='ABCDEFGHJKLMNPQRSTUVXYWZIO';
        let head=id.substring(0,1);
        let n12=letters.indexOf(head)+10;
        let n1=parseInt(n12/10);
        let n2=n12%10;
        let n3=parseInt(id.substring(1,2));
        let n4=parseInt(id.substring(2,3));
        let n5=parseInt(id.substring(3,4));
        let n6=parseInt(id.substring(4,5));
        let n7=parseInt(id.substring(5,6));
        let n8=parseInt(id.substring(6,7));
        let n9=parseInt(id.substring(7,8));
        let n10=parseInt(id.substring(8,9));
        let n11=parseInt(id.substring(9,10));

        let sum=n1*1+n2*9+n3*8+n4*7+n5*6+n6*5+n7*4+n8*3+n9*2+n10*1+n11*1;
        if(sum%10==0){
            return true;
        }
        return false;
    }
    else{
        return false;
    }
}

// 檢查姓名格式
function checkNameFormat(name){
    if (name.match(/^[\u4e00-\u9fa5]{2,4}$/)) {
        return true; 
    } else {    
        return false;
    }
}

// 將html字元轉譯回符號
function unhtmlspecialchars(ch) {
    if (ch===null) return '';
    ch = ch.replace("&quot;","\"");
    ch = ch.replace("&#039;","\'");
    ch = ch.replace("&lt;","<");
    ch = ch.replace("&gt;",">");
    ch = ch.replace("&amp;","&");
    return ch;
    }

// 顯示訊息
function showSingal(signal) {
    if (signal) {
        alert(signal);
    }
}

// 跳轉頁面
function direct(location) {
    if (location) {
        window.location=location;
    }
}

// 檢查內容是否為空
function checkContent(str){
    // str = e.target.value;
    if (str.match(/\S{1,}/)) {
        return true;
    } else {
        return false;
    }
}

// 檢查格式不為小數點或負值
function checkUnsigned(value){
    
    if (!value.match(/^[1-9][0-9]{0,}$/)) {
        return false;
    } else {
        return true;
    }
    
}
