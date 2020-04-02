<?php
if(isset($_FILES['file'])){
    $error = array();
    $upload_dir = 'upload/';
    $upload_file = $upload_dir.$_FILES['file']['name'];
    $type_allow = array('jpg','jpeg','png','gif');
    $type = pathinfo($_FILES['file']['name'],PATHINFO_EXTENSION);
    // kieem tra
    if(!in_array(strtolower($type),$type_allow)){
        $error['type'] = 'chỉ được upload file có đuôi jpg, png, jpeg , gif';
    }else{
        $file_size = $_FILES['file']['size'];
        if($file_size > 21000000){
            $error['size'] = 'chi upload file < 21mb';
        }
        if(file_exists($upload_file)){
            $file_name = pathinfo($_FILES['file']['name'],PATHINFO_FILENAME);
            $file_name_new = $file_name."-coppy.";
            $new_upload_file = $upload_dir.$file_name_new.$type;
            $k=1;
            while(file_exists($new_upload_file)){
                $file_name_new = $file_name."-coppy-{$k}.";
                $k++;
                $new_upload_file = $upload_dir.$file_name_new.$type;
            }
            $upload_file = $new_upload_file;
        }
    }
    if(empty($error)){
      if(  move_uploaded_file($_FILES['file']['tmp_name'],$upload_file)){
          echo "Upload thanh cong";
      }else{
          echo "upload that bai";
      }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>upload file anh len server</title>
</head>
<style>
    .error{
        color: red;
        font-weight: bold;
    }
</style>
<body>
   <form method="post" action="" enctype="multipart/form-data">
       <input type="file" name="file">
       <input type="submit" value="upload">
       <br>
       <p class="error"><?php if(!empty($error['type'])) echo $error['type'];  ?></p>
       <p class="error"><?php if(!empty($error['size'])) echo $error['size'];  ?></p>
      
   </form>
 
</body>
</html>