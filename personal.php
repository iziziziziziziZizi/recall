<!DOCTYPE html >
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>个人信息</title>
<style type="text/css">
body{
	width:auto;
	height:auto;
	background:#F2F2F2;
}
#infoblock{
	margin:20px 0 0 20px;	
}
#line{
	border-color:#e6e6e6;
	display:block;
	padding:0 0 0 0px;
	border-style:solid;
	border-width:1px 0 0 0;
	
}

#btn{
	text-decoration:none;
	font-size:14px;
	float:right;
	margin-top:-21px;
	padding:4px 12px 4px 12px;
	text-align:center;
	border-width: 1px;
    border-style: solid;
    overflow:hidden;
	vertical-align: middle;
	cursor:pointer;
	border-color:#CCC;
	background:#CCC;
	color:#000;
    border-radius:13px;
}
#btn:hover{
	background-color:#F93;
	border-color:#F93;
	color:#FFF;
}
table{
	margin:10px 0 10px 10px;
}
table td{
	margin:15px;
}
table #title{
	float:right;
	color:#666;
	
}
table #context{
	width:300px;
	
}
</style>
</head>

<body onLoad="test()">
<?php  
 	//把个人信息取出来
    session_start ();
	$username = $_SESSION["username"];//获取当前登录的姓名
	$username_show=$_GET["username_show"];//要查看人的姓名
    $con = mysql_connect ( "localhost", "root", "root" );  
    if (! $con) {  
        die ( '数据库连接失败' . $mysql_error () );  
    }  
    mysql_select_db ( "user_info", $con );  
	mysql_query("SET NAMES UTF8");
    $result = mysql_query ( "select * from user_info where username ='{$username_show}';" ); 
    while ( $row = mysql_fetch_array ( $result ) ) {  
    	$dbusername = $row ["username"];
		$dbname = $row ["name"];
		$dbsex = $row ["sex"];
		$dbbirthdate = $row ["birthdate"];
		$dbemail = $row ["email"];
		$dbphone = $row ["phone"];
		$dbaddress = $row ["address"];
		$dbjob = $row ["job"];
		$dbtext = $row ["text"];
    }
?>
<!--个人信息-->
<div id="infoblock">
      <fieldset id="line">
        <legend id="tit">基本信息</legend>
        <?php 
		//判定当前登录人是否是要查看的用户，是就可以编辑
		if($username==$username_show){
		?>
        
		<a href="personal_alter.php?username_show=<?=$username?>" id='btn'>编辑</a>
		<?php
		}
		?>
       
      </fieldset>
      <table>
      	<tr>
        	<td id="title">登录号</td>
            <td id="context"><?php echo $dbusername; ?></td>
        </tr>
        <tr>
        	<td id="title">姓名</td>
            <td id="context"><?php echo $dbname; ?></td>
        </tr>
        <tr>
        	<td id="title">性别</td>
            <td id="context"><?php echo $dbsex; ?></td>
        </tr>
        
         <tr>
        	<td id="title">联系方式</td>
            <td id="context"><?php echo $dbphone; ?></td>
        </tr>
        <tr>
        	<td id="title">邮件</td>
            <td id="context"><?php echo $dbemail; ?></td>
        </tr>
        <tr>
        	<td id="title">出生日期</td>
            <td id="context"><?php echo $dbbirthdate; ?></td>
        </tr> 
        <tr>
        	<td id="title">地址</td>
            <td id="context"><?php echo $dbaddress; ?></td>
        </tr>  
        <tr>
        	<td id="title">职业</td>
            <td id="context"><?php echo $dbjob; ?></td>
        </tr>
        <tr>
        	<td id="title">个人签名</td>
            <td id="context"><?php echo $dbtext; ?></td>
        </tr>
      
      </table>
      
</div>
<script>
function test(){
	var iframe = parent.document.getElementById("Infol");
	iframe.height = 0;
	iframe.height = document.body.scrollHeight;
}
</script>
</body>
</html>
