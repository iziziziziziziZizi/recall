<!DOCTYPE html >
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>修改个人信息</title>
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
	margin:10px 0 20px 10px;
}

table td{
	margin:8px;
}
table input{
	padding:0px;
	margin:0px;
}
table #title{
	float:right;
	color:#666;
	
}
table #context{
	width:300px;
	
}
table #text{
	resize:none;
	width:250px;
}
</style>
</head>

<body onLoad="text()">
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
		$dbname = $row["name"];
		$dbsex = $row ["sex"];
		$dbbirthdate = $row ["birthdate"];
		$dbemail = $row ["email"];
		$dbphone = $row ["phone"];
		$dbaddress = $row ["address"];
		$dbjob = $row ["job"];
		$dbtext  = $row["text"];
    }
?>

<!--个人信息-->
<div id="infoblock">

	<form  action="personal_alter_action.php" method="post" onsubmit="return alter()" enctype="multipart/form-data">  
      <fieldset id="line">
          <legend id="tit">基本信息</legend>
          
        <input type="submit" value="保存" id="btn" onclick="return alter()">
      </fieldset>
      <table cellpadding="8px">
      	<tr>
        	<td id="title">登录号</td>
            <td id="context"><?php echo $dbusername; ?></td>
        </tr>
        <tr>
        	<td id="title">姓名</td>
            <td id="context"><input type="text" name="name" id="name" value="<?php echo $dbname; ?>" maxlength="10"/></td>
        </tr>
        <tr>
        	<td id="title">性别</td>
            <td id="context"><input type="radio" name="sex" value="男" checked >男</label>
        <label><input type="radio" name="sex" value="女">女</label></td>
        </tr>
        
         <tr>
        	<td id="title">联系方式</td>
            <td id="context"><input type="tel" name="phone" id="phone" value="<?php echo $dbphone; ?>" maxlength="11"/></td>
        </tr>
        <tr>
        	<td id="title">邮件</td>
            <td id="context"><input type="email" name="email" id="email" value="<?php echo $dbemail; ?>" maxlength="30"/></td>
        </tr>
        <tr>
        	<td id="title">出生日期</td>
            <td id="context"><input type="date" name="birthdate" id="birthdate" value="<?php echo $dbbirthdate; ?>"/></td>
        </tr> 
        <tr>
        	<td id="title">地址</td>
            <td id="context"><input type="text" name="address" id="address" value="<?php echo $dbaddress; ?> " maxlength="30" /></td>
        </tr> 
         <tr>
        	<td id="title">职业</td>
            <td id="context">
            
            <select id="job" name="job" >
				<option value="老板" <?php if($dbjob=="老板"){echo "selected='selected'";}?>>老板</option>
				<option value="上班族" <?php if($dbjob=="上班族"){echo "selected='selected'";}?>>上班族</option>
				<option value="无业人士" <?php if($dbjob=="无业人士"){echo "selected='selected'";}?>>无业人士</option>
				<option value="学生" <?php if($dbjob=="学生"){?>selected="selected"<?php }?>>学生</option>
             </select>
            </td>
        </tr>
        <tr>
        	<td id="title">个人签名</td>
            <td id="context"><textarea type="text" name="text" id="text" value=" " maxlength="100" clos="100" rows="4" ><?php echo $dbtext; ?></textarea></td>
        </tr> 
      </table>
      </form>
      
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
