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
<?php require_once('Connections/student.php'); ?>
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

mysql_select_db($database_student, $student);
$query_Recordset1 = "SELECT * FROM studadmin";
$Recordset1 = mysql_query($query_Recordset1, $student) or die(mysql_error());
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
  mysql_select_db($database_student, $student);
  
  $LoginRS__query=sprintf("SELECT username, password FROM studadmin WHERE username=%s AND password=%s",
    GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $student) or die(mysql_error());
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
<title>學員資料管理系統</title>
<style type="text/css">
body {
	text-align: center;
	background-color: #FFFFBB;
}
.loginTitle {
	font-size: 36px;
	font-weight: bold;
	color: #F00;
}
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
<div align="center">

  <p>&nbsp;</p>
  <p class="loginTitle">請輸入系統管理者之帳號及密碼</p>
<form id="loginform" name="form1" method="POST" action="<?php echo $loginFormAction; ?>">
  <table width="900" border="1" cellspacing="0" cellpadding="0">
    <tr>
      <td width="500" rowspan="3"><div align="center"><img src="images/login01.png" width="286" height="300" title="login" /></div></td>
      <td width="60" height="30" align="center">帳號</td>
      <td><input name="username" type="text" class="sText" id="user01"/></td>
    </tr>
    <tr>
      <td height="30" align="center">密碼</td>
      <td><input name="password" type="password" class="sText" id="pass01"/></td>
    </tr>
    <tr>
      <td height="240" colspan="2" align="center"><img src="CaptchaSecurityImages.php?width=100&amp;height=40&amp;characters=5" name="imgCaptcha" id="imgCaptcha" /><a href="javascript:void(0)" onclick="RefreshImage('imgCaptcha')" style="font-size:9pt">更換圖片<br />
      </a>
        <input name="security_code" type="text" id="security_code" value="請輸入上方驗證碼" maxlength="10" onfocus="this.value=''" /></td>
    </tr>
  </table>
  <div class="action">
    <div align="center">
      <input type="submit" class="butDef" value="登入系統" />
      &nbsp; 
      &nbsp;
      &nbsp;
      <input name="按鈕" type="button" class="butDef" value="重設" onclick="window.location='index.php'" />
    </div>
  </div>
</form>
</div>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
