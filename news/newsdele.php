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

if ((isset($_POST['delid'])) && ($_POST['delid'] != "") && (isset($_POST['delsure']))) {
  $deleteSQL = sprintf("DELETE FROM newscenter WHERE news_id=%s",
                       GetSQLValueString($_POST['delid'], "int"));

  mysql_select_db($database_news, $news);
  $Result1 = mysql_query($deleteSQL, $news) or die(mysql_error());

  $deleteGoTo = "index.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $deleteGoTo));
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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>新聞系統 - 管理介面</title>
<link href="style.css" rel="stylesheet" type="text/css" media="screen" />
</head>

<body>
<div id="warp">
  <div id="header">
    <div class="topfunction"><a href="newsadd.php" title="新增新聞"><img src="images/File Office - Document.png" alt="新增新聞" width="32" height="32" /></a><img src="images/Lockoff.png" alt="登出管理介面" width="32" height="32" /></div>
    <div class="logo"><img src="images/DWonline.png" width="180" height="40" alt="dreamweaver.com.tw" /></div>
  </div>
  <div class="contentcontainer">
    <div class="headings_red altheading">
      <h2>新聞系統 - 管理介面</h2>
    </div>  
    <div class="contentbox">
    	<!-- Status Bar Start --><!-- Status Bar End -->
        
         <!-- Red Status Bar Start --><!-- Red Status Bar End -->
        
        <!-- Green Status Bar Start --><!-- Green Status Bar End -->
        
        <!-- Blue Status Bar Start --><!-- Blue Status Bar End -->
        <form id="form1" name="form1" method="post" action="">
          <table width="90%" align="center">
            <tr>
              <th colspan="2" align="left"> 刪除新聞</th>
            </tr>
            <tr>
              <td width="20%"><strong>分類</strong></td>
              <td><?php echo $row_Recordset1['news_type']; ?></td>
            </tr>
            <tr>
              <td><strong>標題</strong></td>
              <td><?php echo $row_Recordset1['news_subject']; ?></td>
            </tr>
            <tr>
              <td><strong>日期</strong></td>
              <td><?php echo $row_Recordset1['news_date']; ?></td>
            </tr>
            <tr>
              <td><strong>編輯者</strong></td>
              <td><?php echo $row_Recordset1['news_editor']; ?></td>
            </tr>
            <tr>
              <td><strong>內容</strong></td>
              <td><?php echo $row_Recordset1['news_content']; ?></td>
            </tr>
            <tr>
              <td><strong>審核</strong></td>
              <td><?php echo $row_Recordset1['news_ok']; ?></td>
            </tr>
            <tr>
              <td><strong><font color="#FF0000">是否確定刪除？</font></strong></td>
              <td><input type="submit" name="button" id="button" value="確定" />
              <input type="button" name="button3" id="button3" value="回主頁面" onclick="window.location='admin.php'" />
              <input name="delsure" type="hidden" id="delsure" value="true" />
              <input name="delid" type="hidden" id="delid" value="<?php echo $row_Recordset1['news_id']; ?>" /></td>
            </tr>
          </table>
        </form>

      <div class="extrabottom"></div>
      <div id="footer">&copy; Copyright 2012 eHappy Studio 織夢新聞系統</div>
    </div>
  </div>
</div>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
