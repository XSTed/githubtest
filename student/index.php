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

$colname_Recordset2 = "-1";
if (isset($_GET['id'])) {
  $colname_Recordset2 = $_GET['id'];
}
mysql_select_db($database_student, $student);
$query_Recordset2 = sprintf("SELECT * FROM student WHERE stud_id = %s", GetSQLValueString($colname_Recordset2, "int"));
$Recordset2 = mysql_query($query_Recordset2, $student) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

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
?><style type="text/css">
.studentTitle {
	font-family: "新細明體";
	font-size: 52px;
	color: #FFF;
	text-shadow:10px 10px 15px #333333;
}
.rowTitle {
	color: #00F;
	font-weight: bold;
}
body {
	background-color: #FFFFBB;
}
</style>
<title>學員資料管理系統</title>
<div align="center">
  <table width="900" border="0" cellspacing="0" cellpadding="0">
    <tr bgcolor="#990000">
      <td height="60" align="center" class="studentTitle">學員資料管理系統</td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td height="10">&nbsp;</td>
    </tr>
    <tr>
      <td height="20"><table width="900" border="0" cellspacing="0" cellpadding="0">
        <tr align="center" bgcolor="#FFCCFF" class="rowTitle">
          <td width="40" height="30">學號</td>
          <td width="90" height="30">姓名</td>
          <td width="40" height="30">性別</td>
          <td width="120" height="30">出生日期</td>
          <td width="120" height="30">&nbsp;&nbsp;&nbsp; 身分證字號</td>
          <td width="150" height="30">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 畢業學校</td>
          <td width="150" height="30">&nbsp;&nbsp;&nbsp;&nbsp; 科系</td>
          <td width="120" height="30">&nbsp;&nbsp;&nbsp; 行動電話</td>
          <td width="60" height="30"> 點擊率</td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td><table width="900" border="0" cellspacing="0" cellpadding="0">
        <?php do { ?>
          <tr align="center" bgcolor="#CCCCCC" style="color: #000;">
            <td width="40" height="35"><?php echo $row_Recordset1['stud_id']; ?></td>
            <td width="90" height="35"><a href="detail.php?id=<?php echo $row_Recordset1['stud_id']; ?>&amp;countok=true"><?php echo $row_Recordset1['stud_name']; ?></a></td>
            <td width="40" height="35"><?php echo $row_Recordset1['stud_sex']; ?></td>
            <td width="120" height="35"><?php echo $row_Recordset1['stud_birthday']; ?></td>
            <td width="120" height="35"><?php echo $row_Recordset1['stud_idno']; ?></td>
            <td width="150" height="35"><?php echo $row_Recordset1['stud_school']; ?></td>
            <td width="150" height="35"><?php echo $row_Recordset1['stud_major']; ?></td>
            <td width="120" height="35"><?php echo $row_Recordset1['stud_phone']; ?></td>
            <td width="40" height="35"><?php echo $row_Recordset1['stud_hits']; ?></td>
          </tr>
          <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
      </table></td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <table width="900" border="0" cellspacing="0" cellpadding="0">
    <tr align="center" valign="middle" bgcolor="#FFCC00">
      <td width="450">&nbsp;
記錄 <?php echo ($startRow_Recordset1 + 1) ?> 到 <?php echo min($startRow_Recordset1 + $maxRows_Recordset1, $totalRows_Recordset1) ?> 共 <?php echo $totalRows_Recordset1 ?></td>
      <td width="450">&nbsp;
        <table border="0">
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
</div>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset2);
?>
