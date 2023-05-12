<?php
//啟動 Session
if (!isset($_SESSION)) {
  session_start();
}
//若表單送出時即先檢查驗證碼
if(isset($_POST['security_code'])){
	if(($_SESSION['security_code'] != $_POST['security_code'])||(empty($_SESSION['security_code']))){
		header("Location: index.php?auth=false");
		break;
	}
}
?>
<?php require_once('Connections/news.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

mysql_select_db($database_news, $news);
$query_Recordset1 = "SELECT * FROM newsadmin";
$Recordset1 = mysql_query($query_Recordset1, $news) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['username'])) {
  $loginUsername=$_POST['username'];
  $password=$_POST['password'];
  $MM_fldUserAuthorization = "";
  $MM_redirectLoginSuccess = "admin.php";
  $MM_redirectLoginFailed = "index.php";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_news, $news);
  
  $LoginRS__query=sprintf("SELECT username, password FROM newsadmin WHERE username=%s AND password=%s",
    GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $news) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
     $loginStrGroup = "";
    
	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	      

    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>管理登入介面</title>
<style type="text/css">	
.boxLogin {
	width: 700px;
	margin: auto;
	margin-top: 100px;
	padding: 0px;
	background-image: url(images/adminlogin_bg.png);
	background-repeat:no-repeat;
}

.boxLogin  div.fields {
	/* [disabled]float: right; */
	width: 360px;
	height: 250px;
	overflow: hidden;
	background-color: #FFF;
	border-radius: 10px;
	box-shadow: 2px 2px 2px 2px #999;
	margin-left: 290px;
	padding-top: 20px;
	padding-right: 0;
	padding-bottom: 0;
	padding-left: 50px;
}

.boxLogin  .toolTip{
	width:416px;
	float:right;
}

.boxLogin  .fields p.error {
	background:transparent;
}

.fields p.rem {
	padding:10px 0 0 100px;
}

.fields p label { display:inline-block;}

.action {
	padding:20px 74px 0 0;
	text-align:right;
}
body {background-color: #eaeaea;}
.clearfix {
	/* [disabled]display: block; */
}
.small {
	width: 84px;
	font-size: 13px;
	text-shadow: 1px 1px 0px #CCC;
}
.sep { margin-top:15px; }
</style>
<script language="javascript" type="text/javascript">
//更換驗證碼圖片
function RefreshImage(valImageId) {
	var objImage = document.images[valImageId];
	if (objImage == undefined) {
		return;
	}
	var now = new Date();
	objImage.src = objImage.src.split('?')[0] + '?width=100&height=40&characters=5&s=' + new Date().getTime();
}
</script>
</head>

<body>
<div class="boxLogin clearfix">
  <!-- Tooltip styles  -->
  <form ACTION="<?php echo $loginFormAction; ?>" method="POST" id="loginform">
    <div class="fields">
      <p class="sep">
        <label class="small" for="user01">管理者帳號</label>
        <input name="username" type="text" class="sText" id="user01"/>
      </p>
      <p class="sep">
        <label class="small" for="pass01">管理者密碼</label>
        <input name="password" type="password" class="sText" id="pass01"/>
      </p>
      <p class="sep">&nbsp;<img src="CaptchaSecurityImages.php?width=100&amp;height=40&amp;characters=5" name="imgCaptcha" id="imgCaptcha" /><a href="javascript:void(0)" onclick="RefreshImage('imgCaptcha')" style="font-size:9pt">更換圖片<br />
      </a>
        <input name="security_code" type="text" id="security_code" value="請輸入上方驗證碼" maxlength="10" onfocus="this.value=''" />
      </p>
      <div class="action">
        <input type="submit" class="butDef" value="登入系統" />
        <input name="按鈕" type="button" class="butDef" value="退回首頁" onclick="window.location='index.php'" />
      </div>
    </div>
  </form>
</div>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
