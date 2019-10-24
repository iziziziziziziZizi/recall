<!doctype html>  
<html>  
<head>  
<meta charset="UTF-8">  
<title>正在删除生活圈</title>  
</head>  
<body> 
    <?php  
    session_start ();
	$username = $_SESSION["username"];//当前登录人的姓名
	$parent_id=$_GET["parent_id"];//获取要删除生活圈的id
	
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
        alert("删除失败,用户名不存在");  
        window.location.href="login.html"; 
    </script>   
    <?php  
    }
	//先删除评论
	mysql_query("delete from reply_info where vitasphere_id='$parent_id'") or die("删除数据库失败".mysql_error()) ;
    mysql_query("delete from vitasphere_info where parent_id='$parent_id'") or die("删除数据库失败".mysql_error()) ;  
    mysql_close ( $con );  
    ?>  
  
  
    <script type="text/javascript">  
        alert("删除成功");
        window.location.href="vitasphere.php";  
    </script>  
</body> 
</html> 