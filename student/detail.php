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

$colname_Recordset1 = "-1";
if (isset($_GET['id'])) {
  $colname_Recordset1 = $_GET['id'];
}
mysql_select_db($database_student, $student);
$query_Recordset1 = sprintf("SELECT * FROM student WHERE stud_id = %s", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $student) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

if ((isset($_GET['countok'])) && ($_GET['countok'] != "")) {
  $execSQL = "UPDATE student SET stud_hits=stud_hits+1 WHERE stud_id=".$_GET['id'];

  mysql_select_db($database_student, $student);
  $Result1 = mysql_query($execSQL, $student) or die(mysql_error());

  $execGoTo = "detail.php?id=".$_GET['id'];
  header(sprintf("Location: %s", $execGoTo));
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>無標題文件</title>
<style type="text/css">
.detailTitle {
	font-size: 52px;
	color: #FFF;
	font-family: "標楷體";
}
body {
	background-color: #FFFFBB;
}
body,td,th {
	color: #0000FF;
	font-weight: bold;
}
</style></head>

<body>
<div align="center">
  <table width="900" border="1" cellspacing="0" cellpadding="0">
    <tr align="center" bgcolor="#660000">
      <td height="70" colspan="2" bgcolor="#660000" class="detailTitle">學員資料管理系統</td>
    </tr>
    <tr>
      <td width="200" height="180" align="center">相片</td>
      <td><div align="center"><img src="./images/<?php echo $row_Recordset1['stud_photo']; ?>" alt="photo" width="160" height="160" /></div></td>
    </tr>
    <tr>
      <td height="40" align="center" bgcolor="#99FFFF">姓名</td>
      <td><?php echo $row_Recordset1['stud_name']; ?></td>
    </tr>
    <tr>
      <td height="40" align="center" bgcolor="#99FFFF">性別</td>
      <td><?php echo $row_Recordset1['stud_sex']; ?></td>
    </tr>
    <tr>
      <td height="40" align="center" bgcolor="#99FFFF">出生日期</td>
      <td><?php echo $row_Recordset1['stud_birthday']; ?></td>
    </tr>
    <tr>
      <td height="40" align="center" bgcolor="#99FFFF">身分證字號</td>
      <td><?php echo $row_Recordset1['stud_idno']; ?></td>
    </tr>
    <tr>
      <td height="40" align="center" bgcolor="#99FFFF">畢業學校</td>
      <td><?php echo $row_Recordset1['stud_school']; ?></td>
    </tr>
    <tr>
      <td height="40" align="center" bgcolor="#99FFFF">科系</td>
      <td><?php echo $row_Recordset1['stud_major']; ?></td>
    </tr>
    <tr>
      <td height="40" align="center" bgcolor="#99FFFF">行動電話</td>
      <td><?php echo $row_Recordset1['stud_phone']; ?></td>
    </tr>
    <tr>
      <td height="40" align="center" bgcolor="#99FFFF">地址</td>
      <td><?php echo $row_Recordset1['stud_address']; ?></td>
    </tr>
    <tr align="center">
      <td height="50" align="center" bgcolor="#99FFFF">簡歷資料(附件檔)</td>
      <td align="left"><p>附件檔：<a href="<?php echo '學員簡歷/'.$row_Recordset1['appendix']; ?>" <?php echo "download"; ?>><?php echo $row_Recordset1['appendix']; ?></a></p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="index.html" target="_top">回首頁</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  <a href="index.php" target="main">回上一頁</a></td>
    </tr>
  </table>
</div>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
