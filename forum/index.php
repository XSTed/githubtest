<?php require_once('Connections/forum.php'); ?>
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

$maxRows_Recordset1 = 3;
$pageNum_Recordset1 = 0;
if (isset($_GET['pageNum_Recordset1'])) {
  $pageNum_Recordset1 = $_GET['pageNum_Recordset1'];
}
$startRow_Recordset1 = $pageNum_Recordset1 * $maxRows_Recordset1;

mysql_select_db($database_forum, $forum);
$query_Recordset1 = "SELECT * FROM topic ORDER BY `Time` DESC";
$query_limit_Recordset1 = sprintf("%s LIMIT %d, %d", $query_Recordset1, $startRow_Recordset1, $maxRows_Recordset1);
$Recordset1 = mysql_query($query_limit_Recordset1, $forum) or die(mysql_error());
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
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>討論區首頁</title>
<style type="text/css">
	
</style>
</head>

<body>
<table width="900" border="0" align="center">
  <tbody>
    <tr>
      <td style="text-align: center; font-size: 72px;">討論區首頁</td>
    </tr>
  </tbody>
</table>
	<hr>
<p>&nbsp;</p>
<table width="900" border="0" align="center">
  <tbody>
    <tr>
      <td style="text-align: right"><a href="post.php">發表主題</a> &nbsp;&nbsp;<a href="search.php">搜尋</a></td>
    </tr>
  </tbody>
</table>
<p>&nbsp;</p>

	  <table width="900" border="0" align="center">
	    <tbody>
	      <tr style="">
	        <td width="606">主題</td>
	        <td width="145">發表人</td>
	        <td width="135">時間</td>
          </tr>
	 	<?php do { ?>     
	      <tr>
	        <td><a href="topic.php?TopicID=<?php echo $row_Recordset1['TopicID']; ?>"><?php echo $row_Recordset1['Title']; ?></a></td>
	        <td><?php echo $row_Recordset1['Nickname']; ?></td>
	        <td><?php echo $row_Recordset1['Time']; ?></td>
          </tr>
	    <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
        </tbody>
  </table>
	 
<p>&nbsp;</p>
<table width="900" border="0" align="center">
  <tbody>
    <tr>
      <td width="220"><?php if ($pageNum_Recordset1 > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, 0, $queryString_Recordset1); ?>">第一頁</a>
      <?php } // Show if not first page ?></td>
      <td width="220"><?php if ($pageNum_Recordset1 > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, max(0, $pageNum_Recordset1 - 1), $queryString_Recordset1); ?>">上一頁</a>
      <?php } // Show if not first page ?></td>
      <td width="220"><?php if ($pageNum_Recordset1 < $totalPages_Recordset1) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, min($totalPages_Recordset1, $pageNum_Recordset1 + 1), $queryString_Recordset1); ?>">下一頁</a>
      <?php } // Show if not last page ?></td>
      <td width="222"><?php if ($pageNum_Recordset1 < $totalPages_Recordset1) { // Show if not last page ?>
  <a href="<?php printf("%s?pageNum_Recordset1=%d%s", $currentPage, $totalPages_Recordset1, $queryString_Recordset1); ?>">最後一頁</a>
  <?php } // Show if not last page ?></td>
    </tr>
  </tbody>
</table>

</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
