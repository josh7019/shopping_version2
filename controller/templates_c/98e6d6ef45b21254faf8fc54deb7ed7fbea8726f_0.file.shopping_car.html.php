<?php
/* Smarty version 3.1.33, created on 2019-08-06 17:37:44
  from 'C:\xampp\htdocs\shopping\views\shopping_car.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5d494a68f018b3_01497506',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '98e6d6ef45b21254faf8fc54deb7ed7fbea8726f' => 
    array (
      0 => 'C:\\xampp\\htdocs\\shopping\\views\\shopping_car.html',
      1 => 1565084185,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5d494a68f018b3_01497506 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
    <?php echo '<script'; ?>
 src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="/shopping/scripts/functions.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="/shopping/scripts/shopping_car.js"><?php echo '</script'; ?>
>
    <title>Document</title>
    <style>
        .table-striped > thead > tr {
            background-color: #27ae60;
            color: white;
            text-align:center
        }
        #itemArea > tr > td > img{
            width: 100px;
            height: 100px;
        }
        body {
            font-family: arial,"Microsoft JhengHei","微軟正黑體",sans-serif !important;
            color:#808080;
            background-color:#1c1c1c; 
        }
        #button_colum {
            width: 170px;
        }
        th {
            text-align: center;
        }
        tr {
            text-align: center;
        }
        .item-color-1 {
                background-color:#f6f6f6;
            }
        .item-color-2 {
            background-color:#e9e9e9;
        }
    </style>
</head>
<body>
        <!-- 導覽列 -->
        <nav class="navbar navbar-inverse">
            <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                
                <a class="navbar-brand" href="/shopping/controller/usercontroller.php/index">商城首頁</a>
                </div>
            
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <?php ob_start();
if ($_smarty_tpl->tpl_vars['is_login']->value) {
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
                    <li><a href="/shopping/controller/usercontroller.php/shoppingcar"><span class="glyphicon glyphicon-list-alt"></span> 我的訂單</a></li>
                    <li><a href="/shopping/controller/usercontroller.php/shoppingcar"><span class="glyphicon glyphicon-shopping-cart"></span> 購物車</a></li>
                    <li class="dropdown"></li>
                </ul>
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
    </nav>


        <div class='container' style="text-align: center">
            <div id="nowTime"></div>
            <div>
                    <legend>購物車</legend>
                <!-- 會員顯示區 -->
                <table class="table table-striped" id='title'>
                    <thead>
                        <tr>
                            <th style="width:110px">商品圖片</th>
                            <th>商品名稱</th>
                            <th>商品庫存</th>
                            <th>商品價格</th>
                            <th>購買數量</th>
                            <th id='button_colum'></th>
                        </tr>
                    </thead>
                    <tbody id='itemArea'>
                        <?php ob_start();
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['product_list']->value, 'product_item');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['product_item']->value) {
$_prefixVariable4 = ob_get_clean();
echo $_prefixVariable4;?>

                        <tr class="item-color-1">
                            <input type="hidden" value="<?php ob_start();
echo $_smarty_tpl->tpl_vars['product_item']->value['product_id'];
$_prefixVariable5 = ob_get_clean();
echo $_prefixVariable5;?>
">
                            <td><img src="/shopping/img/<?php ob_start();
echo $_smarty_tpl->tpl_vars['product_item']->value['image'];
$_prefixVariable6 = ob_get_clean();
echo $_prefixVariable6;?>
" alt=""></td>
                            <td><?php ob_start();
echo $_smarty_tpl->tpl_vars['product_item']->value['name'];
$_prefixVariable7 = ob_get_clean();
echo $_prefixVariable7;?>
</td>
                            <td><?php ob_start();
if ($_smarty_tpl->tpl_vars['product_item']->value['stock'] < 10) {
$_prefixVariable8 = ob_get_clean();
echo $_prefixVariable8;?>
 <?php ob_start();
echo $_smarty_tpl->tpl_vars['product_item']->value['stock'];
$_prefixVariable9 = ob_get_clean();
echo $_prefixVariable9;?>
 <?php ob_start();
} else {
$_prefixVariable10 = ob_get_clean();
echo $_prefixVariable10;?>
 庫存量充足 <?php ob_start();
}
$_prefixVariable11 = ob_get_clean();
echo $_prefixVariable11;?>
</td>
                            <td><?php ob_start();
echo $_smarty_tpl->tpl_vars['product_item']->value['price'];
$_prefixVariable12 = ob_get_clean();
echo $_prefixVariable12;?>
</td>
                            <td><input class='amount' type='number' min='1' value="<?php ob_start();
echo $_smarty_tpl->tpl_vars['product_item']->value['amount'];
$_prefixVariable13 = ob_get_clean();
echo $_prefixVariable13;?>
" style="width:50px"></td>
                            <td>
                                <span class="pull-right delete_button">
                                    <span class="btn btn-danger">
                                        <span class="glyphicon glyphicon-remove">
                                        </span>
                                        從購物車移除
                                    </span>
                                </span>
                            </td>
                        </tr>
                        <?php ob_start();
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
$_prefixVariable14 = ob_get_clean();
echo $_prefixVariable14;?>

                    </tbody>
                </table><!-- 會員顯示區結束 -->
            </div>
        </div>
        <input type="hidden" id='message' value='<?php ob_start();
echo $_smarty_tpl->tpl_vars['message']->value;
$_prefixVariable15 = ob_get_clean();
echo $_prefixVariable15;?>
'>
        
        
        <?php echo '<script'; ?>
 type="text/javascript" src=''><?php echo '</script'; ?>
>
        <?php echo '<script'; ?>
 
        src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js" 
        integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" 
        crossorigin="anonymous">
        <?php echo '</script'; ?>
>
</body>
</html><?php }
}
