<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>生活圈</title>
<link rel="stylesheet" href="css/vitasphere.css" type="text/css" />

</head>

<body>
<?php
session_start ();	
$username = $_SESSION["username"];//当前登录人
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
<!-- 发生活圈-->
<div id="head">
	<!-- 发生活圈div-->
	<div id="release_form">
    	<p>来分享你的点点滴滴</p>
		<form action="vitasphere_action.php" name="form" method="post" enctype="multipart/form-data" onsubmit="return enter('release_form_content');"> 
        <!--发生活圈的字数限定-->
        <p id="content_size">还可以输入<input name="remLen" type="text" value="200" size="3" readonly>字</p>
        <!--发生活圈的输入框-->
		<textarea  type="text" name="content" id ="release_form_content" clos="250" rows="6" onKeyDown="textCounter(content,remLen,200);" onKeyUp="textCounter(content,remLen,200);"></textarea> <br/>
        <!--发生活圈的文件选择框-->
		<input type="file" name="file" id ="file"/>
		<input type="submit" name="submit" id="button" value="发布" /> 
		</form> 
	</div>
	<!-- 个人信息的显示-->
	<div id="personal">
    	<!--获取当前登录人的头像和背景-->
    	<?php 
		//获取当前登录人的头像和背景
		mysql_query("SET NAMES UTF8");
    	$user_result = mysql_query ( "select img_name,bg_img_name from user_info where username ='{$username}';" ); 
		while ( $row = mysql_fetch_array ( $user_result ) ) {
			$img_name = $row ["img_name"];//获取用户头像
			$bg_img_name = $row ["bg_img_name"];//获取背景
    	}
		?>
        <!--个人信息上面的背景图片-->
		<img id="personal_top" src="bgimages/<?php echo $bg_img_name;?>" />
    	<!--个人信息地用户头像-->
        <div id="personal_img_div">
        <img id="personal_img" src="userimage/<?php echo $img_name;?>"  onClick="personal('<?=$username?>');" />
        </div>        
        <!--个人信息的姓名-->
        <span id="username" onClick="personal('<?=$username?>');" ><?php echo "$username";//显示登录用户名 ?></span><br />


        <!--个人信息下面的关注，粉丝，生活圈-->
        <div id="personal_bottom">
        	<div id="attention"><span id="mun">25</span><br /><span id="text">关注</span></div>
        	<div id="fans"><span id="mun">25</span><br /><span id="text">粉丝</span></div>
        	<div id="vitasphere"><span id="mun">25</span><br /><span id="text">生活圈</span></div>
        </div>
	</div>
</div>
  
  <!--生活圈的显示-->
  <div id="content_show">
  
       <table>
 		 <?php 
		 //设置一页显示多谢数据
    	$page_size=10; 
    	//获取所以数据
		mysql_query("SET NAMES UTF8");
    	$result=mysql_query('select * from vitasphere_info'); 
    	$count = mysql_num_rows($result);
		 //计数有多页
		 $page_count = ceil($count/$page_size);
    	 $page_len=7; //页数的显示个数
		 $init=1;//数字值的第一个数
		 $max_p=$page_count;//数字值的最大个数
		 $pages=$page_count; //总页数
		 //判断当前页码
		 if(empty($_GET['page'])||$_GET['page']<0){//如果page没有付值或小于0就附1，
				 $page=1;
		 }else{
			 $page=$_GET['page'];
		 }
		 $offset=$page_size*($page-1);//记录从数据库的几个数据开始读出
    	 $result = mysql_query ( "select * from vitasphere_info a ORDER BY a.time desc limit $offset,$page_size" );
		  
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
				<img src="userimage/<?php echo $img_name; ?>" id="user_img" onClick="personal('<?=$row ["username"]?>');"/>
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
                </td>
             </tr>
             <!--分页的显示-->
             <?php
			 //分页
			}
			$pageoffset = ($page_len-1)/2;//页码个数篇页量
			$key='<div id="page">';
			//单页数为不了一时,第一页和上一页的有超链接
			if($page!=1){
				$key.="<span><a href=\"".$_SERVER['PHP_SELF']."?page=1\">首页</a></span>"; //第一页 ,其中？号是get到上面的if。
				$key.="<span><a href=\"".$_SERVER['PHP_SELF']."?page=".($page-1)."\"> << </a></span>"; //上一页 
			}else {
				 /*
				 $key.="<span id='page_lose'>首页</span>";//第一页 
        		 $key.="<span id='page_lose'>上一页</span>"; //上一页 
				 */
    		}
			//中间的数值的偏移值（数字值的显示范围）
			if($pages>$page_len){
				//如果当前页数小于等于左偏移 
				if($page<=$pageoffset){
					$init=1;
					$max_p = $page_len; 
				}else{//如果当前页大于左偏移
				 
					//如果当前页码右偏移超出最大分页数
					if($page+$pageoffset>=$pages+1){
						$init = $pages-$page_len+1;
					}else{	
    					//左右偏移都存在时的计算 
						$init = $page-$pageoffset; 
    					$max_p = $page+$pageoffset; 
					}
				 }
			}
			//数字值的显示
			for($i=$init;$i<=$max_p;$i++){
				if($i==$page){
					$key.='<span id="page_show">'.$i.'</span>';//当前页面不显示超链接
				}else{
					$key.="<span><a href=\"".$_SERVER['PHP_SELF']."?page=".$i."\">".$i."</a></span>";//其他到有超链接
				}
			}
			//判定是不是最好一页，是就不显示最后一页和下一页
			if($page!=$pages){
				$key.="<span><a href=\"".$_SERVER['PHP_SELF']."?page=".($page+1)."\"> >> </a></span>";//下一页 
    			$key.="<span><a href=\"".$_SERVER['PHP_SELF']."?page={$pages}\">尾页</a></span>"; //最后一页 
			}else{
				/*
				$key.="<span id='page_lose'>下一页</span>";//下一页 
    			$key.="<span id='page_lose'>尾页</span>"; //最后一页 
				*/
			}
			$key.='</div>';
			?>
            <tr> 
    			<td><?php echo $key?></td> 
    		</tr>  
        </table>
   </div>

   <div id="foot">
    <iframe src="foot.html" scrolling="no" frameborder="0" allowtransparency 

="yes"></iframe>
   </div>

<script>
//点击隐藏或显示的函数
function isHidden(oDiv){
    var vDiv = document.getElementById(oDiv);
    vDiv.style.display = (vDiv.style.display == 'block')?'none':'block';
}

//字数的限制数
function textCounter(field, countfield, maxlimit) {
// 函数，3个参数，表单名字，表单域元素名，限制字符；
if (field.value.length > maxlimit)
//如果元素区字符数大于最大字符数，按照最大字符数截断；
field.value = field.value.substring(0, maxlimit);
else
//在记数区文本框内显示剩余的字符数；
countfield.value = maxlimit - field.value.length;
}


//判定回复的字数是否为空
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
	window.location.href="vitasphere_del_action.php";//跳转到个人页面 
}
</script>
</body>
</html>
