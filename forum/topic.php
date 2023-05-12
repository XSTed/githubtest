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

$colname_Recordset1 = "-1";
if (isset($_GET['TopicID'])) {
  $colname_Recordset1 = $_GET['TopicID'];
}
mysql_select_db($database_forum, $forum);
$query_Recordset1 = sprintf("SELECT * FROM topic WHERE TopicID = %s", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $forum) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

$maxRows_Recordset2 = 10;
$pageNum_Recordset2 = 0;
if (isset($_GET['pageNum_Recordset2'])) {
  $pageNum_Recordset2 = $_GET['pageNum_Recordset2'];
}
$startRow_Recordset2 = $pageNum_Recordset2 * $maxRows_Recordset2;

$colname_Recordset2 = "-1";
if (isset($_GET['TopicID'])) {
  $colname_Recordset2 = $_GET['TopicID'];
}
mysql_select_db($database_forum, $forum);
$query_Recordset2 = sprintf("SELECT * FROM reply WHERE Reply_TopicID = %s ORDER BY ID ASC", GetSQLValueString($colname_Recordset2, "int"));
$query_limit_Recordset2 = sprintf("%s LIMIT %d, %d", $query_Recordset2, $startRow_Recordset2, $maxRows_Recordset2);
$Recordset2 = mysql_query($query_limit_Recordset2, $forum) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);

if (isset($_GET['totalRows_Recordset2'])) {
  $totalRows_Recordset2 = $_GET['totalRows_Recordset2'];
} else {
  $all_Recordset2 = mysql_query($query_Recordset2);
  $totalRows_Recordset2 = mysql_num_rows($all_Recordset2);
}
$totalPages_Recordset2 = ceil($totalRows_Recordset2/$maxRows_Recordset2)-1;
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>無標題文件</title>
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
	<table width="900" border="0" align="center">
  <tbody>
    <tr>
      <td><a href="index.php">討論區首頁</a></td>
      <td style="text-align: right"><a href="post.php">發表主題</a> <a href="search.php">搜尋</a></td>
    </tr>
  </tbody>
</table>
<p>&nbsp;</p>
<table width="900" border="0" align="center">
  <tbody>
    <tr>
      <td width="160">&nbsp;</td>
      <td width="730" style="text-align: left"><table width="730" border="0">
          <tbody>
            <tr>
              <td width="620"><?php echo $row_Recordset1['Title']; ?></td>
              <td width="100"><a href="reply.php?TopicID=<?php echo $row_Recordset1['TopicID']; ?>">回覆主題</a></td>
            </tr>
          </tbody>
      </table>
	</td>
    </tr>
    <tr style="text-align: center">
      <td>發表人</td>
      <td>內容</td>
    </tr>
    <tr>
      <td style="text-align: center"><?php echo $row_Recordset1['Nickname']; ?></td>
      <td><?php echo $row_Recordset1['Content']; ?></td>
    </tr>
    <tr>
      <td style="text-align: center"><a href="deltopic.php?TopicID=<?php echo $row_Recordset1['TopicID']; ?>"><img src="img/icon_delete.gif" width="15" height="18" alt=""/></a><a href="mailto: <?php echo $row_Recordset1['Email']; ?>
"><img src="img/icon_email.gif" width="30" height="18" alt=""/></a></td>
      <td><table width="730" border="0">
        <tbody>
          <tr>
            <td style="text-align: right">發表時間:<?php echo $row_Recordset1['Time']; ?></td>
          </tr>
        </tbody>
      </table></td>
    </tr>
  </tbody>
</table>
<?php if ($totalRows_Recordset2 > 0) { // Show if recordset not empty ?>
  <?php do { ?>
    <table width="900" border="0" align="center">
      <tbody>
        <tr>
          <td width="160"><span style="text-align: center"><?php echo $row_Recordset2['Nickname']; ?></span></td>
          <td width="730"><?php echo $row_Recordset2['Content']; ?></td>
        </tr>
        <tr>
          <td><span style="text-align: center"><a href="delreply.php?ID=<?php echo $row_Recordset2['ID']; ?>&TopicID=<?php echo $row_Recordset1['TopicID']; ?>"><img src="img/icon_delete.gif" width="15" height="18" alt=""/></a><a href="mailto:<?php echo $row_Recordset2['Email']; ?>"><img src="img/icon_email.gif" width="30" height="18" alt=""/></a></span></td>
          <td style="text-align: right">發表時間:<?php echo $row_Recordset2['Time']; ?></td>
        </tr>
      </tbody>
    </table>
    <?php } while ($row_Recordset2 = mysql_fetch_assoc($Recordset2)); ?>
  <?php } // Show if recordset not empty ?>
</body>
</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset2);
?>
