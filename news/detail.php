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

$colname_Recordset1 = "-1";
if (isset($_GET['id'])) {
  $colname_Recordset1 = $_GET['id'];
}
mysql_select_db($database_news, $news);
$query_Recordset1 = sprintf("SELECT * FROM newscenter WHERE news_id = %s", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $news) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

if ((isset($_GET['countok'])) && ($_GET['countok'] != "")) {
  $execSQL = "UPDATE newscenter SET news_hits=news_hits+1 WHERE news_id=".$_GET['id'];

  mysql_select_db($database_news, $news);
  $Result1 = mysql_query($execSQL, $news) or die(mysql_error());

  $execGoTo = "detail.php?id=".$_GET['id'];
  header(sprintf("Location: %s", $execGoTo));
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>新聞系統</title>
<link href="style.css" rel="stylesheet" type="text/css" media="screen" />
</head>

<body>
<div id="warp">
  <div id="header">
    <div class="topfunction"> <a href="#" title="回到首頁"><img src="images/House.png" alt="回到首頁" width="32" height="32" /></a><a href="#" title="登入管理介面"><img src="images/Lock.png" alt="登入管理介面" width="32" height="32" /></a></div>
    <div class="logo"><img src="images/DWonline.png" width="180" height="40" alt="dreamweaver.com.tw" /></div>
  </div>
  <div class="contentcontainer">
    <div class="headings altheading">
      <h2>新聞系統</h2>
    </div>  
    <div class="contentbox">
      <table width="100%">
        <tr>
          <th align="left"><span class="typeblock">&nbsp;&nbsp;</span>&nbsp;&nbsp;<?php echo $row_Recordset1['news_type']; ?>&nbsp; <?php echo $row_Recordset1['news_subject']; ?></th>
        </tr>
        <tr>
          <td><span class="newsinfo">
            <img src="images/date.png" alt="" /> <?php echo $row_Recordset1['news_date']; ?>&nbsp;&nbsp;<img src="images/user.png" alt="" />&nbsp;<?php echo $row_Recordset1['news_editor']; ?>&nbsp;<strong></strong> 
            <img src="images/icon_facebook.png" alt="" width="16" height="16" />&nbsp;&nbsp;<img src="images/icon_google.png" alt="" width="16" height="16" />&nbsp;&nbsp;</span>
            <p>&nbsp;&nbsp;<?php echo $row_Recordset1['news_content']; ?></p>
            <p align="right">附件檔：<a href="<?php echo '附件檔/'.$row_Recordset1['appendix']; ?>" <?php echo "download"; ?>><?php echo $row_Recordset1['appendix']; ?></a></p>
          </td>
        </tr>
      </table>
      
      <div class="extrabottom">
        <table width="100%" border="0" cellpadding="0" cellspacing="0" class="simpletb">
          <tr>
            <td align="center"> <a href="index.php" class="btnblock">回到首頁</a><a href="index.php" class="btnblock">回上一頁</a></td>
          </tr>
        </table>
      </div>
      <div id="footer">&copy; Copyright 2012 eHappy Studio 織夢新聞系統</div>
    </div>
  </div>
</div>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
