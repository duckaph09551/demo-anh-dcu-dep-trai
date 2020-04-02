<?php
//  TODO: Thông tin file upload
// $_FILES['file']['name'] => tên file
// $_FILES['file']['type']  => loại file
// $_FILES['file']['type'] => kích thuwocs file
// $_FILES['file']['tmp_name'] => đường dẫn file tạm
//$_FILES['file']['error'] => thông báo lỗi

require ('lib/data.php');
show_array($_FILES);
if(isset($_FILES['file'])){
    $upload_dir = 'upload/';
    $upload_file = $upload_dir.$_FILES['file']['name'];
    //TODO: xử lý uplaod đúng file ảnh
    $type_allow = array('png','jpg','gif','jpeg');
    // show_array($type_allow);
    // lấy đuôi file
    $type = pathinfo($_FILES['file']['name'],PATHINFO_EXTENSION);
    // echo $type;
   //kiểm tra đuôi file
   $error =array();
   TODO: //Hàm in_array() trong php dùng để kiểm tra giá trị nào đó có tồn tại trong mảng hay không. Nếu như tồn tại thì nó sẽ trả về TRUE và ngược lại sẽ trả về FALSE.
   if(!in_array(strtolower($type),$type_allow)){
       $error['type'] = 'chỉ được upload file có đuôi jpg, png, jpeg , gif';
   }else{
        // uplaod fiile có kích thuwocs cho phép < 20mb ~ 21tr byte
        $file_size = $_FILES['file']['size'];
        // echo $file_size;
        if($file_size > 20971520){
            $error['size'] = 'chỉ được upload file < 20mb';
        }
            // kiểm tra trùng tên hay không
            if(file_exists($upload_file)){
                // tạo file mới  tenfile.đuổi file
                 $file_name = pathinfo($_FILES['file']['name'],PATHINFO_FILENAME);
                 $file_name_new = $file_name.'-Copy';
                $new_upload_file =  $upload_dir. $file_name_new.$type;
                  
                $k = 1;
                while(file_exists($new_upload_file)){
                     $file_name_new = $file_name."-Copy ({$k}).";
                     $k++;
                     $new_upload_file =  $upload_dir. $file_name_new.$type;
                }
                $upload_file = $new_upload_file;
            }
            // nếu trùng tên file thì đổi tên file
   }
   if(empty($error)){
    if(move_uploaded_file($_FILES['file']['tmp_name'],$upload_file)){
          echo " <a href='$upload_file'>Dowload {$_FILES['file']['name']}</a>";
    }else{
        echo "uplaod file thất bại";
    }
   }else{
       show_array($error);
   }


    // TODO: unlink xóa ảnh trên server
    //   $file_url = "upload/hinh-nen-girl-xinh.jpg";
    //   if(unlink($file_url)){
    //       echo "xóa file {$file_url} thành công";
    //   }else{
    //       echo "xóa file {$file_url} không thành công";
    //   }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>upload file anh len server</title>
</head>
<body>
   <form method="post" action="" enctype="multipart/form-data">
       <input type="file" name="file">
       <input type="submit" value="upload">
   </form>
</body>
</html>