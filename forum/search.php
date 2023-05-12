<?php require_once('Connections/forum.php'); ?>
<?php
function cut200($str) {
	$str = strip_tags($str);
	$str = mb_substr($str,0,200,"utf-8");
	return $str;
}
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

$colname_rstopic = "@#$%^&*!";
if (isset($_POST['Keyword'])) {
  $colname_rstopic = $_POST['Keyword'];
}
mysql_select_db($database_forum, $forum);
$query_rstopic = sprintf("SELECT * FROM topic WHERE Title LIKE %s OR Content LIKE %s ORDER BY TopicID DESC", GetSQLValueString("%" . $colname_rstopic . "%", "text"),GetSQLValueString("%" . $colname_rstopic . "%", "text"));
$rstopic = mysql_query($query_rstopic, $forum) or die(mysql_error());
$row_rstopic = mysql_fetch_assoc($rstopic);
$totalRows_rstopic = mysql_num_rows($rstopic);

$colname_rsreply = "@#$%^&*!";
if (isset($_POST['Keyword'])) {
  $colname_rsreply = $_POST['Keyword'];
}
mysql_select_db($database_forum, $forum);
$query_rsreply = sprintf("SELECT topic.TopicID,topic.Title,reply.Content FROM topic INNER JOIN reply ON topic.TopicID=reply.Reply_TopicID WHERE reply.Content LIKE %s ORDER BY ID DESC", GetSQLValueString("%" . $colname_rsreply . "%", "text"));
$rsreply = mysql_query($query_rsreply, $forum) or die(mysql_error());
$row_rsreply = mysql_fetch_assoc($rsreply);
$totalRows_rsreply = mysql_num_rows($rsreply);
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>無標題文件</title>
</head>

<body><table width="900" border="1" align="center">
  <tbody>
    <tr>
      <td width="400"><a href="index.php">討論區首頁</a> | <a href="javascript:history.back(-1);">回上一頁</a></td>
      <td width="484" style="text-align: right"><a href="post.php">發表主題</a> <a href="search.php">搜尋</a></td>
    </tr>
  </tbody>
</table>
<p>&nbsp;</p>
<table width="900" border="1" align="center">
  <tbody>
    <tr>
      <td style="text-align: right"><form id="form1" name="form1" method="post">
          <label for="textfield">搜尋關鍵字:</label>
          <input type="text" name="Keyword" id="Keyword">
          <input type="submit" name="submit" id="submit" value="送出">
      </form>
      </td>
    </tr>
  </tbody>
</table>
<p>&nbsp;</p>
<?php do { ?>
    <?php if ($totalRows_rstopic > 0) { // Show if recordset not empty ?>
      <table width="900" border="1" align="center">
        <tbody>
          <tr>
            <td style="background-color: #0570C8; color: white;">於主題(<?php echo $row_rstopic['Title']; ?>)</td>
          </tr>
          <tr>
            <td><?php echo cut200($row_rstopic['Content']); ?></td>
          </tr>
          <tr>
            <td style="text-align: right"><a href="topic.php?TopicID=<?php echo $row_rstopic['TopicID']; ?>">閱讀這篇主題</a></td>
          </tr>
        </tbody>
      </table>
      <?php } // Show if recordset not empty ?>
<?php } while ($row_rstopic = mysql_fetch_assoc($rstopic)); ?>
<p>&nbsp;</p>
	<?php do { ?>
        <?php if ($totalRows_rsreply > 0) { // Show if recordset not empty ?>
  <table width="900" border="1" align="center">
    <tbody>
      <tr>
        <td style="background-color: #0570C8; color: white;">於主題(<?php echo $row_rsreply['Title']; ?>)</td>
        </tr>
      <tr>
        <td><?php echo cut200($row_rsreply['Content']); ?></td>
        </tr>
      <tr>
        <td style="text-align: right"><a href="topic.php?TopicID=<?php echo $row_rsreply['TopicID']; ?>">閱讀這篇主題</a></td>
        </tr>
      </tbody>
  </table>
  <?php } // Show if recordset not empty ?>
<?php } while ($row_rsreply = mysql_fetch_assoc($rsreply)); ?>
</body>
</html>
<?php
mysql_free_result($rstopic);

mysql_free_result($rsreply);
?>
