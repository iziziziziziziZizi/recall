<!doctype html>  
<html>  
<head>  
<meta charset="UTF-8">  
<title>正在发布生活圈</title>  
</head>  
<body> 
    <?php  
    session_start ();
	$username = $_SESSION["username"];
    $content = $_REQUEST ["content"];
	
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
	//这个应该是移动图片失败
	}
	
	
	
     //连接数据库
    $con = mysql_connect ( "localhost", "root", "root" );  
    if (! $con) {  
        die ( '数据库连接失败' . $mysql_error () );  
    }  
    mysql_select_db ( "user_info", $con );  
    $dbusername = null;

   	mysql_query("SET NAMES utf8");
    $result = mysql_query ( "select * from user_info where username ='{$username}';" );  
    while ( $row = mysql_fetch_array ( $result ) ) {  
        $dbusername = $row ["username"];
    }
    if (is_null ( $dbusername )) {  
        ?>  
    <script type="text/javascript">  
        alert("发布失败,用户名不存在");  
        window.location.href="login.html"; 
    </script>   
    <?php  
    }
	
    mysql_query("insert into vitasphere_info (username,img_name,time,content) values('{$username}','{$img_name}',now(),'{$content}')") or die("存入数据库失败".mysql_error()) ;  
    mysql_close ( $con );  
    ?>  
  
  
    <script type="text/javascript">  
        alert("发布成功");
        window.location.href="vitasphere.php";  
    </script>  
</body> 
</html> 