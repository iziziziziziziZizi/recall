<!doctype html>  
<html>  
<head>  
<meta charset="UTF-8">  
    <title>正在注册用户</title>  
</head>  
<body>  
    <?php   
        session_start();  
        $username=$_REQUEST["username"];  
        $password=$_REQUEST["password"];  
		$img_name='all_userimages.jpg';
		
  
        $con=mysql_connect("localhost","root","root");  
        if (!$con) {  
            die('数据库连接失败'.$mysql_error());  
        }  
        mysql_select_db("user_info",$con);  
        $dbusername=null;  
        $dbpassword=null;  
        $result=mysql_query("select * from user_info where username ='{$username}';");  
        while ($row=mysql_fetch_array($result)) {  
            $dbusername=$row["username"];  
            $dbpassword=$row["password"];  
        }  
        if(!is_null($dbusername)){  
    ?>  
    <script type="text/javascript">  
        alert("用户已存在");  
        window.location.href="register.html";  
    </script>   
    <?php   
        } 
		mysql_query("SET NAMES UTF8"); 
        mysql_query("insert into user_info (username,password,img_name,bg_img_name) values ('{$username}','{$password}','all_userimages.jpg','all_bg.jpg');") or die("存入数据库失败".mysql_error()) ;
        
		mysql_close($con);//暂停
    ?>  
    <script type="text/javascript">  
        alert("注册成功");  
        window.location.href="login.html";  
    </script>  

          
</body>  
</html> 