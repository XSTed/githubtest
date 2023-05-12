<?php require_once('Connections/cnupload.php'); ?>
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

$maxRows_rs_upload = 10;
$pageNum_rs_upload = 0;
if (isset($_GET['pageNum_rs_upload'])) {
  $pageNum_rs_upload = $_GET['pageNum_rs_upload'];
}
$startRow_rs_upload = $pageNum_rs_upload * $maxRows_rs_upload;

mysql_select_db($database_cnupload, $cnupload);
$query_rs_upload = "SELECT * FROM upload ORDER BY ID DESC";
$query_limit_rs_upload = sprintf("%s LIMIT %d, %d", $query_rs_upload, $startRow_rs_upload, $maxRows_rs_upload);
$rs_upload = mysql_query($query_limit_rs_upload, $cnupload) or die(mysql_error());
$row_rs_upload = mysql_fetch_assoc($rs_upload);

if (isset($_GET['totalRows_rs_upload'])) {
  $totalRows_rs_upload = $_GET['totalRows_rs_upload'];
} else {
  $all_rs_upload = mysql_query($query_rs_upload);
  $totalRows_rs_upload = mysql_num_rows($all_rs_upload);
}
$totalPages_rs_upload = ceil($totalRows_rs_upload/$maxRows_rs_upload)-1;
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>無標題文件</title>
</head>

<body>
<table width="600" border-collapse="collapse" align="center">
  <tbody>
    <tr>
      <td style="text-align: right"><a href="upload.php">新增檔案</a></td>
    </tr>
  </tbody>
</table>
	<br>
	<?php do { ?>
	  <table width="600" border-collapse="collapse" align="center">
	    <tbody>
	      <tr>
	        <td width="80">名稱：</td>
	        <td width="175"><?php echo $row_rs_upload['UserFilename']; ?></td>
	        <td width="80">大小：</td>
	        <td width="175"><?php echo $row_rs_upload['Size']; ?></td>
	        <td width="90"><a href="download.php?ServerFilename=<?php echo $row_rs_upload['ServerFilename']; ?>&UserFilename=<?php echo $row_rs_upload['UserFilename']; ?>">
				下載</a> | <a href="del.php">刪除</a></td>
          </tr>
	      <tr>
	        <td colspan="5">說明：<?php echo $row_rs_upload['Comment']; ?></td>
          </tr>
        </tbody>
  </table>
	  <?php } while ($row_rs_upload = mysql_fetch_assoc($rs_upload)); ?>
</body>
</html>
<?php
mysql_free_result($rs_upload);
?>
