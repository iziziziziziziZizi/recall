
<!DOCTYPE html >
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>个人</title>
<style type="text/css">
/*头部*/
#head{
	width:800px;
	margin:0 auto;
}
/*个人信息div*/
#personal{
	box-shadow:1px 1px 0 1px rgba(0,0,0,0.15);
	margin:0 auto;
    width:100%;;
    height:300px;
	background:url(bgimages/all_bg.jpg);
	background-size:100%;
}
/*个人信息中的用户头像*/
#personal_img{
	width:100px;
	height:100px;
	margin-top:42px;
	margin-left:340px;/*通过personal的宽度减当前图片宽度除2*/
	border:1px solid #CCC;
	padding:2px;
	border-radius:50%;/*圆形*/
	cursor:pointer;/*变手型*/
}
/*个人信息的姓名和个人签名显示div*/
#username_and_text{
	margin-left:70px;
	width:80%;
	padding:10px;
	background:rgba(255, 255, 255, 0.6)!important;
	margin-top:4px;
    text-align:center;
}
/*姓名显示*/
#username_and_text #username{
	margin:0px;
	color:#666;
	font-size:25px;
    display: inline;
}
/*个人签名显示*/
#username_and_text #text{
	margin:5px;
	font-size:16px;
	color:#666;
    text-align:center;
}


/*导航条的div*/
#nav{
	text-align:center;
	margin:0 auto;
	width:100%;
	background:#FFF;
	min-width:572px;
	padding:8px 0 8px 0;
	box-shadow:0 1px 1px 1px rgba(0,0,0,0.2);

}
#nav span{
	margin:0 80px 0 80px;
	cursor:pointer;/*变手型*/
	color:#000;
	font-weight:bold;
}

/*中间显示的div*/
#centre{
	width:800px;
	margin:0 auto;
	margin-top:10px;
}
/*中间显示左边div*/
#centre_left{
	width:30%;
	float:left;
	background:#ECECEC;
}

/*中间显示右边div*/
#centre_right{
	width:69%;
	background:#ECECEC;
	float:right;
}
#centre_right{text-align:center;}
	

	
/*foot*/
#foot{text-align:center;margin:0 auto;}
#foot iframe{height:200px;width:100%;}
	
	
</style>

</head>
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
        $name = $row ["name"];
		$img_name = $row ["img_name"];
		$bg_img_name = $row ["bg_img_name"];
		$text = $row ["text"];
    }
 
//判定是否为异常登录
if (!isset ( $_SESSION ["code"] )) {//判断code存不存在，如果不存在，说明异常登录  
//code不存在，调用exit.php 退出登录
?>  
	<script type="text/javascript">  
   		alert("登录异常，请重新登录");  
   		window.location.href="exit.php";  
	</script>  
<?php  
}  
?>

<body onLoad="goIframe('<?=$username_show?>','vitasphere_show');">


<div id="head">
	<div id="personal">
          <img src="userimage/<?php echo $img_name;?>" id="personal_img" />
    	  <!--姓名和个人签名的显示div-->
          <div id="username_and_text">
          	<!--姓名-->
    		<h3 id="username"><?php echo $name; ?></h3>
            <!--个人签名-->
    		<h3 id="text"><?php echo $text; ?></h3>
		  </div>
          <!--个人信息下面的关注，粉丝，生活圈-->
          
	</div>
	<div id="nav">
    	<span onClick="goIframe('<?=$username_show?>','personal');">个人资料</span>
    	<span onClick="goIframe('<?=$username_show?>','vitasphere_show');">生活圈</span>
    	<span onClick="goIframe('<?=$username_show?>','diary');">日记</span>
	</div>
 
	
</div>
<div id="centre">
	
    <iframe name="Infol" id="Infol" width="100%" scrolling="no" frameborder="0"></iframe>
   
</div>

  <div id="foot">
    <iframe src="foot.html" scrolling="no" frameborder="0" allowtransparency 

="yes"></iframe>
   </div>




<script>  
function goIframe(username_show,name){
	var oiframe = document.getElementById("Infol");
	if(name=="personal"){
		oiframe.src="personal.php?username_show="+username_show;
	}
	else if(name=="vitasphere_show"){
		oiframe.src="vitasphere_show.php?username_show="+username_show;
	}
	else if(name=="diary"){
		oiframe.src="diary.html?username_show="+username_show;
	}
} 
</script>  

</body>


</html>
