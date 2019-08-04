<?php
/* Smarty version 3.1.33, created on 2019-07-31 09:18:21
  from 'C:\xampp\htdocs\shopping\views\manager_login.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5d4140bd300a15_94738649',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'f1731112bfcecdb8f2c6e7a45d3718d2b985a89d' => 
    array (
      0 => 'C:\\xampp\\htdocs\\shopping\\views\\manager_login.html',
      1 => 1564557499,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5d4140bd300a15_94738649 (Smarty_Internal_Template $_smarty_tpl) {
?>
<!DOCTYPE html>
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
 type="text/javascript" src='../scripts/functions.js'><?php echo '</script'; ?>
>
        <?php echo '<script'; ?>
 type="text/javascript" src='../scripts/manager_login.js'><?php echo '</script'; ?>
>
        <title>Document</title>
        <style>
            .myform {
                margin-top:20%;
                color: red;
                width:50%;
                margin-left:25%;
                text-align:center;
                border-radius: 20px;
            }
            body {
            font-family: arial,"Microsoft JhengHei","微軟正黑體",sans-serif !important;
            color:#a6a6a6;
            background-color:#1c1c1c; 
        }
            th {
                text-align: center;
            }
            tr {
                text-align: center;
            }
            #title {
                color: red;
            }
            #login_form {
                background-color: #262626
            }
        </style>
    </head>
    <body>
        <!-- 導覽列 -->
        <nav class="navbar navbar-inverse">
            <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                
                <a class="navbar-brand" href="PageController.php?action=index">Brand</a>
                </div>
            
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li class=""><a href="ManagerPageController.php?action=login"><span class="glyphicon glyphicon-user"></span> 管理者登入 <span class="sr-only">(current)</span></a></li>
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
                
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
    </nav>
        <!-- 導覽列結束 -->

        
        <div class='container'>
            
            <form id='login_form' class="form-horizontal myform" >
            <fieldset>
            <!-- Form Name -->
            <legend id='title'>管理者登入</legend>
            <!-- Text input-->
            <div class="form-group">
                <label class="col-md-4 control-label" for="Account">帳號</label>  
                <div class="col-md-4">
                    <input id="account" name="account" type="text" placeholder="請輸入帳號" class="form-control input-md" required>
                </div>
            </div>

            <!-- Text input-->
            <div class="form-group">
                <label class="col-md-4 control-label" for="password">密碼</label>  
                <div class="col-md-4">
                    <input id="password" name="password" type="password" placeholder="請輸入密碼" class="form-control input-md" required>
                </div>
            </div>

            <!-- Button -->
            <div class="form-group">
                <label class="col-md-4 control-label" for="signin"></label>
                <div class="col-md-4">
                    <button id='login_button' type='button' id="signin" name="signin" class="btn btn-info">登入</button>
                    <a href="../controller/PageController.php?action=signup" class='btn btn-success'>註冊</a>
                </div>
            </div>
            </fieldset>
            </form>
        </div>
        <input type="hidden" id='message' value='<?php ob_start();
echo $_smarty_tpl->tpl_vars['message']->value;
$_prefixVariable1 = ob_get_clean();
echo $_prefixVariable1;?>
'>
    
        <?php echo '<script'; ?>
 
        src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js" 
        integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" 
        crossorigin="anonymous">
    <?php echo '</script'; ?>
>
    </body>
</html><?php }
}
