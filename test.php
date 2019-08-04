<?php
$files=$_FILES["image"];
echo json_encode($files);

        if (!$files["error"]) {//判斷是否有誤
            //判斷圖片格式及大小
           if (($files["type"] == "image/png" || $files["type"] == "image/jpeg") && $files["size"] < 10240000) {
                    //存放位置及檔名
                    $filename = "img/".$files["name"];
                     //檢查目錄是否存在
                    if (!file_exists($filename)) {
                        $is_upload=move_uploaded_file($files["tmp_name"],$filename);//存放檔案
                        if($is_upload) {
                            $data['head_img']=$filename;//圖片位置
                        }
                    } else {
                        $is_upload=move_uploaded_file($files["tmp_name"],$filename);
                        if($is_upload){
                            $data['head_img']=$filename;
                        }
                    }
            }    
        }