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

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_Recordset1 = 10;
$pageNum_Recordset1 = 0;
if (isset($_GET['pageNum_Recordset1'])) {
  $pageNum_Recordset1 = $_GET['pageNum_Recordset1'];
}
$startRow_Recordset1 = $pageNum_Recordset1 * $maxRows_Recordset1;

mysql_select_db($database_student, $student);
$query_Recordset1 = "SELECT * FROM student";
$query_limit_Recordset1 = sprintf("%s LIMIT %d, %d", $query_Recordset1, $startRow_Recordset1, $maxRows_Recordset1);
$Recordset1 = mysql_query($query_limit_Recordset1, $student) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);

if (isset($_GET['totalRows_Recordset1'])) {
  $totalRows_Recordset1 = $_GET['totalRows_Recordset1'];
} else {
  $all_Recordset1 = mysql_query($query_Recordset1);
  $totalRows_Recordset1 = mysql_num_rows($all_Recordset1);
}
$totalPages_Recordset1 = ceil($totalRows_Recordset1/$maxRows_Recordset1)-1;

$queryString_Recordset1 = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_Recordset1") == false && 
        stristr($param, "totalRows_Recordset1") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_Recordset1 = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_Recordset1 = sprintf("&totalRows_Recordset1=%d%s", $totalRows_Recordset1, $queryString_Recordset1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>學員資料管理系統</title>
<style type="text/css">
.adminColumn {
	color: #00F;
	font-weight: bold;
}
.adminColumn {
}
.adminColumn td table tr td {
	text-align: center;
}
.adminData {
	text-align: center;
	font-family: "標楷體";
}
.adminData {
	font-weight: bold;
}
.adminData {
	color: #90F;
}
body {
	background-color: #FFFFBB;
}
</style>
</head>

<body>
<div align="center">
  <p>&nbsp;</p>
  <table width="900" border="0" cellspacing="0" cellpadding="0">
    <tr bgcolor="#000000">
      <td height="60" align="center" style="font-size: 48px; color: #FFF; text-shadow:10px 10px 15px #333333;"><strong>學員資料管理系統----系統管理者使用</strong></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td height="30" bgcolor="#FFFFFF"><div align="right"><a href="addStudent.php" target="main"><img src="images/plusAdmin.png" width="36" height="36" alt="addStudent" /></a>&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;</div></td>
    </tr>
    <tr class="adminColumn">
      <td><table width="900" border="0" cellspacing="0" cellpadding="0">
        <tr bgcolor="#FFCCFF">
          <td width="40" height="30" bgcolor="#FFCCFF">學號</td>
          <td width="80" height="30" bgcolor="#FFCCFF">姓名</td>
          <td width="40" height="30" bgcolor="#FFCCFF">性別</td>
          <td width="120" height="30" bgcolor="#FFCCFF">出生日期</td>
          <td width="120" height="30" bgcolor="#FFCCFF">身分證字號</td>
          <td width="240" height="30" bgcolor="#FFCCFF">畢業學校</td>
          <td width="110" height="30" bgcolor="#FFCCFF">行動電話</td>
          <td width="150" height="30" bgcolor="#FFCCFF">資料處理</td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td><table width="900" border="0" cellspacing="0" cellpadding="0">
        <?php do { ?>
          <tr bgcolor="#EEEEEE" class="adminData">
            <td width="40" height="30"><?php echo $row_Recordset1['stud_id']; ?></td>
            <td width="80" height="30"><?php echo $row_Recordset1['stud_name']; ?></td>
            <td width="40" height="30"><?php echo $row_Recordset1['stud_sex']; ?></td>
            <td width="120" height="30"><?php echo $row_Recordset1['stud_birthday']; ?></td>
            <td width="120" height="30"><?php echo $row_Recordset1['stud_idno']; ?></td>
            <td width="240" height="30"><?php echo $row_Recordset1['stud_school']; ?></td>
            <td width="110" height="30"><?php echo $row_Recordset1['stud_phone']; ?></td>
            <td width="150" height="30">&nbsp; <a href="editStudent.php?id=<?php echo $row_Recordset1['stud_id']; ?>">修改</a>&nbsp; <a href="deleteStudent.php?id=<?php echo $row_Recordset1['stud_id']; ?>">刪除</a></td>
          </tr>
          <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
      </table></td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <table width="900" border="1" cellpadding="0" cellspacing="0" bordercolor="#FF0000" bgcolor="#FF9933">
    <tr>
      <td width="450" height="30" align="center" valign="middle">&nbsp;
記錄 <?php echo ($startRow_Recordset1 + 1) ?> 到 <?php echo min($startRow_Recordset1 + $maxRows_Recordset1, $totalRows_Recordset1) ?> 共 <?php echo $totalRows_Recordset1 ?></td>
      <td width="450" height="30" align="center" valign="middle"><table border="0">
          <tr>
            <td><?php if ($pageNum_Recordset1 > 0) { // Show if not first page ?>
                <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, 0, $queryString_Recordset1); ?>">第一頁</a>
                <?php } // Show if not first page ?></td>
            <td><?php if ($pageNum_Recordset1 > 0) { // Show if not first page ?>
                <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, max(0, $pageNum_Recordset1 - 1), $queryString_Recordset1); ?>">上一頁</a>
                <?php } // Show if not first page ?></td>
            <td><?php if ($pageNum_Recordset1 < $totalPages_Recordset1) { // Show if not last page ?>
                <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, min($totalPages_Recordset1, $pageNum_Recordset1 + 1), $queryString_Recordset1); ?>">下一頁</a>
                <?php } // Show if not last page ?></td>
            <td><?php if ($pageNum_Recordset1 < $totalPages_Recordset1) { // Show if not last page ?>
                <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, $totalPages_Recordset1, $queryString_Recordset1); ?>">最後一頁</a>
                <?php } // Show if not last page ?></td>
          </tr>
      </table></td>
    </tr>
  </table>
  <p>&nbsp;</p>
</div>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
