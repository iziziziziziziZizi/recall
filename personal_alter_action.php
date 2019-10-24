<!doctype html>  
<html>  
<head>  
<meta charset="UTF-8">  
<title>正在修改个人信息</title>  
</head>  
<body> 
    <?php  
    session_start ();
	$username = $_SESSION["username"];
	$name = $_REQUEST ["name"];
    $sex = $_REQUEST ["sex"];
    $birthdate = $_REQUEST ["birthdate"]; 
    $phone = $_REQUEST ["phone"];
	$email = $_REQUEST ["email"];
    $address = $_REQUEST ["address"];
	$job = $_REQUEST ["job"];
	$text = $_REQUEST ["text"];
	
	
	/*
	
	//图片的上传
	
	$file = $_FILES['file'];//得到传输的数据
	//得到文件名称 
	$img_name = $file['name']; 
	$type = strtolower(substr($name,strrpos($name,'.')+1)); //得到文件类型，并且都转化成小写 
	$allow_type = array('jpg','jpeg','gif','png'); //定义允许上传的类型 //判断文件类型是否被允许上传 
	 
	$upload_path = "D:/WWW/MyWeb/userimage/"; 
  	//上传文件的存放路径 //开始移动文件到相应的文件夹 
  	if(move_uploaded_file($file['tmp_name'],$upload_path.$file['name'])){   
  		echo "移动图片成功!"; 
  	}else{   
	?>
 	<script type="text/javascript">  
        alert("修改失败,无法移动图片"); 
        window.location.href="alter_personal.php";    
    </script>
 	<?php 
	}
	*/
     //连接数据库
    $con = mysql_connect ( "localhost", "root", "root" );  
    if (! $con) {  
        die ( '数据库连接失败' . $mysql_error () );  
    }  
    mysql_select_db ( "user_info", $con );
	$dbimg_name = null;

   	mysql_query("SET NAMES utf8");
    $result = mysql_query ( "select * from user_info where username ='{$username}';" );  
    while ( $row = mysql_fetch_array ( $result ) ) {  
        $dbusername = $row ["username"];
    }
    if (is_null ( $dbusername )) {  
        ?>  
    <script type="text/javascript">  
        alert("修改失败,用户名不存在");  
        window.location.href="login.html"; 
    </script>   
    <?php
    }
    mysql_query ("update  user_info set name='{$name}',sex='{$sex}',birthdate='{$birthdate}',phone='{$phone}',email='{$email}',address='{$address}',job='{$job}',text='{$text}' where username='{$username}'") or die ( "存入数据库失败" . mysql_error () );//添加数据到数据库  
    mysql_close ( $con );  
    ?>  

    <script type="text/javascript">
        window.location.href="personal.php?username_show=<?=$username?>";  
    </script>  
</body> 
</html> 