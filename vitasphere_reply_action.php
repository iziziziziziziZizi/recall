<!doctype html>  
<html>  
<head>  
<meta charset="UTF-8">  
    <title>回复信息</title>  
</head>  
<body>  
    <?php   
        session_start();
		$username = $_SESSION["username"];//当前登录的用户
	    $content = $_REQUEST["content"];  
		$vitasphere_id = $_REQUEST["vitasphere_id"];//记录vitasphere_info表的id
		$byreply_name = $_REQUEST["byreply_name"];//被回复人的名字
		
        $con=mysql_connect("localhost","root","root");  
        if (!$con) {  
            die('数据库连接失败'.$mysql_error());  
        }  
        mysql_select_db("user_info",$con);  
        $dbusername=null;  
        $dbpassword=null;  
		$result=mysql_query("SET NAMES UTF8");
        $result=mysql_query("select * from user_info where username ='{$username}';");  
        while ($row=mysql_fetch_array($result)) {  
            $dbusername=$row["username"]; 
        }  
        if(is_null($dbusername)){  
    ?>  
    <script type="text/javascript">  
        alert("回复失败，用户不存在，请重新登录");  
        window.location.href="login.html";  
    </script>   
    <?php   
        }
		mysql_query("SET NAMES UTF8"); 
        mysql_query("insert into reply_info(reply_name,vitasphere_id,reply_content,reply_time,byreply_name) values('{$username}','${vitasphere_id}','{$content}',now(),'{$byreply_name}')") or die("存入数据库失败".mysql_error()) ; 
        mysql_close($con);
    ?>  
    <script type="text/javascript">  
        alert("回复成功");  
        window.location.href="vitasphere.php";  
    </script>  
          
</body>  
</html> 