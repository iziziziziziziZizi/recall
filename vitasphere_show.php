<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>生活圈</title>
<link rel="stylesheet" href="css/vitasphere_show.css" type="text/css" />

</head>

<body onLoad="test()">
<?php
session_start ();	
$username = $_SESSION["username"];//当前登录人
$username_show=$_GET["username_show"];//要查看人的姓名
$tempname = null;//记录
      
$con = mysql_connect ( "localhost", "root", "root" );  
if (! $con) {  
	die ( '数据库连接失败' . $mysql_error () );  
}  
mysql_select_db ( "user_info", $con );
		
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
  <!--生活圈的显示-->
  <div id="content_show">
  
       <table>
 		 <?php 
    	//获取所以数据
		mysql_query("SET NAMES UTF8");
    	$result=mysql_query("select * from vitasphere_info where username='{$username_show}';"); 
		while ($row = mysql_fetch_array ( $result ) ) { 
		?>
             <tr>
                <td>
                <!--用户图片的显示-->
                <div id="left"> 
                <?php
					//获取用户的头像
					$tempname = $row ["username"];//获取发帖人的姓名
    				$result_img_name = mysql_query ( "select img_name from user_info where username='$tempname';" );//通过名字来查询头像姓名
					$img_name_row = mysql_fetch_array($result_img_name);
					$img_name = $img_name_row ["img_name"];
				?>
                <!--发帖用户图片显示-->
				<img src="userimage/<?php echo $img_name; ?>" id="user_img"/>
                </div>
               <!--生活圈的内容-->
                <div id="right">
                <!--发帖人的姓名显示-->
                <span id="username"><?php echo $row ["username"]; ?></span><br />
                <!--生活圈内容显示-->
                <p id="content"><?php echo $row ["content"]; ?></p>
                <?php if($row ["img_name"]){?><img id="personal_image" src="vitasphereimages/<?php echo $row ["img_name"];?>" /><?php }?>
                <br /><br />
                <!--生活圈的的操作-->
                <span id="time"><?php echo $row ["time"]; ?></span>
                <?php 
				//判定生活圈的发送人是不是当前登录人
				if($row ["username"]==$username){
				?>
                <span id="delete"  onClick="del(<?=$row ["parent_id"]?>);">删除</span>
                <?php
				}
				?>
                
                <span id="reply" onclick="isHidden('reply_form_<?php echo $row ["parent_id"]; ?>')">评论</span>    
                <!--第一次回复的表单-->         
                <div id="reply_form_<?php echo $row ["parent_id"]; ?>" class="all_reply_form">
                <form action="vitasphere_reply_action.php" method="post" onsubmit="return enter('reply_content_<?php echo $row ["parent_id"]; ?>')">
                <input type="text" class="all_reply_content" name="content" id="reply_content_<?php echo $row ["parent_id"]; ?>" maxlength="100"/>
                <!--生活圈的id，隐藏起来，赋值为生活圈的id-->
                <input type="text" id="vitasphere_id" name="vitasphere_id"  value="<?php echo $row ["parent_id"]; ?>"/>
                <input type="submit"  value="评论" id="reply_button"/><br  />
                </form>
                </div>
                <!--获取所以评论-->     
                <?php
				//获取所以评论
				$tempid = $row ["parent_id"];//获取生活圈的id
   				$reply_content_result = mysql_query ( "select * from reply_info where vitasphere_id='$tempid';" );//通过生活圈的id来查询所以回复
				//开始输出所以回复
				while ($reply_content_row = mysql_fetch_array ($reply_content_result) ) { 
				?>
                <!--回复内容的显示 -->
                <div id="reply_content_show">
                <!--回复人的姓名-->
                <span id="username"><?php echo $reply_content_row ["reply_name"];?></span>
                <!--判定有没有被回复的人-->
                <?php 
				//判定有没有被回复的人
				if($reply_content_row ["byreply_name"]!=""){
				?>
                回复
                <!--如果人就显示出来-->
                <span id="username"><?php echo $reply_content_row ["byreply_name"];?></span>
				<?php
				}
				?>
                :
                <!--显示回复的内容-->
                <span id="reply_content" onclick="isHidden('all_reply_form_two_<?php echo $reply_content_row ["Id"]; ?>')"><?php echo $reply_content_row ["reply_content"];?></span>
                <!--评论里的回复表单 -->
                <div id="all_reply_form_two_<?php echo $reply_content_row ["Id"]; ?>" class="all_reply_form_two">
                <form action="vitasphere_reply_action.php" method="post" onsubmit="return enter('all_reply_comtent_two_<?php echo $reply_content_row ["Id"]; ?>')">
                <input type="text" class="all_reply_content" name="content" id="all_reply_comtent_two_<?php echo $reply_content_row ["Id"]; ?>"  maxlength="100"/>
                <!--生活圈的id，隐藏起来，赋值为生活圈的id-->
                <input type="text" id="vitasphere_id" name="vitasphere_id" value="<?php echo $row ["parent_id"]; ?>"/>
                <!--被回复的人，隐藏，赋值为，上一次回复的人-->
                <input type="text" id="byreply_name" name="byreply_name" value="<?php echo $reply_content_row ["reply_name"]; ?>"/>
                <input type="submit"  value="评论" id="reply_button"/><br  />
                </form>
                </div>
                </div>
                
				<?php
				}
				?>
                </div>
                
                </div>
                <br /><br /><br />
                </td>
             </tr>
             
             <?php
			}
			?>
           
        </table>
   </div>

<script>
//点击隐藏或显示的函数
function isHidden(oDiv){
    var vDiv = document.getElementById(oDiv);
    vDiv.style.display = (vDiv.style.display == 'block')?'none':'block';
}
//判定回复的字数是否大于100
 function enter(Ocontent)  
        {  
			alert(Ocontent);
            var content = document.getElementById(Ocontent).value;
			alert(content);  
			content = content.replace(/(^\s*)|(\s*$)/g, "");
            if(content.length==0)//判定用户名的是否前后有空格或者用户名是否为空  
                {  
                    alert("发送失败！内容为空");  
                    return false;  
                } 
            return true;  
        }
//用户名的点击事件 
function personal(username){
	alert(username);
	window.location.href="home.php?username_show="+username;//跳转到个人页面 
}
//删除生活圈的点击事件 
function del(parent_id){
	alert(parent_id);
	window.location.href="vitasphere_del_action.php?parent_id="+parent_id;//跳转到个人页面 
}
function test(){
	var iframe = parent.document.getElementById("Infol");	
	iframe.height = 0;
	iframe.height = document.body.scrollHeight;
}
</script>
</body>
</html>
