<?php
/* Smarty version 3.1.33, created on 2019-08-08 19:10:52
  from 'C:\xampp\htdocs\shopping\views\manager_add_product.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5d4c033cb7be25_02847607',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'd68bf6d8cbfd86cbac07844695f65740df8bf6f0' => 
    array (
      0 => 'C:\\xampp\\htdocs\\shopping\\views\\manager_add_product.html',
      1 => 1565262651,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5d4c033cb7be25_02847607 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" 
        integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
        <?php echo '<script'; ?>
 src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"><?php echo '</script'; ?>
>
        <?php echo '<script'; ?>
 type="text/javascript" src='/shopping/scripts/functions.js'><?php echo '</script'; ?>
>
        <?php echo '<script'; ?>
 type="text/javascript" src='/shopping/scripts/manager_add_product.js'><?php echo '</script'; ?>
>
        
        <title>Document</title>
        <style>
            .myform{
                margin-top:20%;
                width:50%;
                margin-left:25%;
                text-align:center;
                border-radius: 20px;
            }
            body {
            font-family: arial,"Microsoft JhengHei","微軟正黑體",sans-serif !important;
            background-color:#1c1c1c; 
            }
            #title {
                color:red;
            }
            #add_product {
                background-color: #262626
            }
            .descript {
                color:red;
            }
            
        </style>
    </head>
    <body>
        
        <!-- 導覽列 -->
        <nav class="navbar navbar-inverse">
            <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                
                <a class="navbar-brand" href="/shopping/controller/userController.php/index">商城首頁</a>
                </div>
            
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <?php ob_start();
if (!$_smarty_tpl->tpl_vars['is_login']->value) {
$_prefixVariable1 = ob_get_clean();
echo $_prefixVariable1;?>

                    <li class=""><a href="/shopping/controller/usercontroller.php/login"><span class="glyphicon glyphicon-user"></span> 登入 <span class="sr-only">(current)</span></a></li>
                    <li><a href="/shopping/controller/usercontroller.php/signup"><span class="glyphicon glyphicon-tower"></span> 註冊</a></li>
                    <?php ob_start();
} else {
$_prefixVariable2 = ob_get_clean();
echo $_prefixVariable2;?>

                    <li><a href="/shopping/controller/usercontroller.php/logout"><span class="glyphicon glyphicon-tower"></span> 登出</a></li>
                    <?php ob_start();
}
$_prefixVariable3 = ob_get_clean();
echo $_prefixVariable3;?>

                    <?php ob_start();
if ($_smarty_tpl->tpl_vars['permission']->value == 5) {
$_prefixVariable4 = ob_get_clean();
echo $_prefixVariable4;?>

                    <li class=""><a href="/shopping/controller/managercontroller.php/member"><span class="glyphicon glyphicon-user"></span> 會員管理 <span class="sr-only">(current)</span></a></li>
                    <li><a href="/shopping/controller/managercontroller.php/product"><span class="glyphicon glyphicon-list-alt"></span> 產品管理 </a></li>
                    <?php ob_start();
}
$_prefixVariable5 = ob_get_clean();
echo $_prefixVariable5;?>

                    
                    
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                          <li><a href="#">Action</a></li>
                          <li><a href="#">Another action</a></li>
                          <li><a href="#">Something else here</a></li>
                          <li role="separator" class="divider"></li>
                          <li><a href="#">Separated link</a></li>
                          <li role="separator" class="divider"></li>
                          <li><a href="#">One more separated link</a></li>
                        </ul>
                      </li>
                </ul>
                
                <ul class="nav navbar-nav navbar-right">
                    <form class="navbar-form navbar-left">
                            <div class="form-group">
                            <input type="text" class="form-control" placeholder="Search">
                            </div>
                            <button type="button" class="btn btn-default">搜尋商品</button>
                    </form>
                    <?php ob_start();
if ($_smarty_tpl->tpl_vars['is_login']->value) {
$_prefixVariable6 = ob_get_clean();
echo $_prefixVariable6;?>

                        <?php ob_start();
if ($_smarty_tpl->tpl_vars['permission']->value == 5) {
$_prefixVariable7 = ob_get_clean();
echo $_prefixVariable7;?>

                        
                        <li>
                            <a href="/shopping/controller/managercontroller.php/orderMenu">
                                <span class="glyphicon glyphicon-list-alt"></span> 訂單管理
                            </a>
                        </li>
                        <?php ob_start();
} else {
$_prefixVariable8 = ob_get_clean();
echo $_prefixVariable8;?>

                            <li>
                                <a href="/shopping/controller/usercontroller.php/shoppinghistory">
                                    <span class="glyphicon glyphicon-list-alt"></span> 我的訂單
                                </a>
                            </li>
                            <li>
                                <a href="/shopping/controller/usercontroller.php/shoppingcar">
                                    <span class="glyphicon glyphicon-shopping-cart"></span> 購物車
                                    <span class="badge badge-light" id='product_count'>
                                        <?php ob_start();
if (isset($_smarty_tpl->tpl_vars['order_detail_list_length']->value)) {
$_prefixVariable9 = ob_get_clean();
echo $_prefixVariable9;?>

                                        <?php ob_start();
echo $_smarty_tpl->tpl_vars['order_detail_list_length']->value;
$_prefixVariable10 = ob_get_clean();
echo $_prefixVariable10;?>

                                        <?php ob_start();
} else {
$_prefixVariable11 = ob_get_clean();
echo $_prefixVariable11;?>

                                        0
                                        <?php ob_start();
}
$_prefixVariable12 = ob_get_clean();
echo $_prefixVariable12;?>

                                    </span>
                                </a>
                            </li>
                        <?php ob_start();
}
$_prefixVariable13 = ob_get_clean();
echo $_prefixVariable13;?>

                        <?php ob_start();
} else {
$_prefixVariable14 = ob_get_clean();
echo $_prefixVariable14;?>

                            <li>
                                <a href="/shopping/controller/usercontroller.php/shoppinghistory">
                                    <span class="glyphicon glyphicon-list-alt"></span> 我的訂單
                                </a>
                            </li>
                            <li>
                                <a href="/shopping/controller/usercontroller.php/shoppingcar">
                                    <span class="glyphicon glyphicon-shopping-cart"></span> 購物車
                                    <span class="badge badge-light" id='product_count'>
                                        <?php ob_start();
if (isset($_smarty_tpl->tpl_vars['order_detail_list_length']->value)) {
$_prefixVariable15 = ob_get_clean();
echo $_prefixVariable15;?>

                                        <?php ob_start();
echo $_smarty_tpl->tpl_vars['order_detail_list_length']->value;
$_prefixVariable16 = ob_get_clean();
echo $_prefixVariable16;?>

                                        <?php ob_start();
} else {
$_prefixVariable17 = ob_get_clean();
echo $_prefixVariable17;?>

                                        0
                                        <?php ob_start();
}
$_prefixVariable18 = ob_get_clean();
echo $_prefixVariable18;?>

                                    </span>
                                </a>
                            </li>
                    <?php ob_start();
}
$_prefixVariable19 = ob_get_clean();
echo $_prefixVariable19;?>

                </ul>
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
        </nav>
        
        <div class='container'>        
            <form id='add_product' class="form-horizontal myform">
            <fieldset>

            <!-- Form Name -->
            <legend class='descript'>新增產品</legend>
            
            <!-- 名稱輸入 -->
            <div class="form-group">
                <label class="col-md-4 control-label descript"  for="name">產品名稱</label><span class='descript' id='name_signal'></span>
                <div class="col-md-4">
                    <input id="name" autocomplete='off' name="name" type="text" placeholder="請輸入產品名稱" class="form-control input-md" required="">    
                    <span class="help-block"></span> 
                </div>
            </div>

            <!-- 價格輸入-->
            <div class="form-group">
                <label class="col-md-4 control-label descript" for="price">價格</label><span class='descript' id='price_signal'></span>  
                <div class="col-md-4">
                    <input id="price" name="price" type="number" min="1" placeholder="請輸入價格" class="form-control input-md" required="">
                    <span class="help-block"></span> 
                </div>
            </div>

            <!-- 庫存輸入-->
            <div class="form-group">
                    <label class="col-md-4 control-label descript" for="price">庫存量</label><span class='descript' id='stock_signal'></span>  
                    <div class="col-md-4">
                        <input id="price" name="stock" type="number" min="1" placeholder="請輸入庫存量" class="form-control input-md" required="">
                        <span class="help-block"></span> 
                    </div>
                </div>

            <!-- 商品狀態選擇-->
            <div class="form-group descript">
                <label class="col-md-4 control-label" for="status">商品狀態</label><span id='status_signal'></span>
                <div class="col-md-4">
                    <select name="status" id="status">
                        <option value="0" selected>待上架</option>
                        <option value="1">售賣中</option>
                    </select>
                </div>
            </div>

            <!-- 產品描述輸入-->
            <div class="form-group">
                    <label class="col-md-4 control-label descript" for="descript">產品描述</label><span class='descript' id='descript_signal'></span>
                    <div class="col-md-4">
                        <textarea name="descript" id="descript" cols="30" rows="5"></textarea>
                    </div>
            </div>
            
            <!-- 上傳圖片 -->
            <div class="form-group descript">
                <label class="col-md-4 control-label" for="image">上傳圖片</label>
                <div class="col-md-4">
                    <input type="file" name='image'>
                </div>
            </div>

            <!-- 送出按鈕 -->
            <div class="form-group">
                <label class="col-md-4 control-label" for="login"></label>
                <div class="col-md-4">
                    <button type='button' id="add_button" name="add_button" class="btn btn-success">確定新增</button>
                </div>
            </div>

            <input type="hidden" name='action' value='addProduct'>
            
            </fieldset>
            </form>
        </div>
        
        
        <?php echo '<script'; ?>
 
        src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js" 
        integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" 
        crossorigin="anonymous">
        <?php echo '</script'; ?>
>
        <!-- 清除message -->
    </body>
</html><?php }
}
