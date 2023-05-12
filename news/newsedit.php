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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE newscenter SET news_type=%s, news_date=%s, news_subject=%s, news_content=%s, news_editor=%s, news_ok=%s WHERE news_id=%s",
                       GetSQLValueString($_POST['news_type'], "text"),
                       GetSQLValueString($_POST['news_date'], "date"),
                       GetSQLValueString($_POST['news_subject'], "text"),
                       GetSQLValueString($_POST['news_content'], "text"),
                       GetSQLValueString($_POST['news_editor'], "text"),
                       GetSQLValueString($_POST['news_ok'], "text"),
                       GetSQLValueString($_POST['news_id'], "int"));

  mysql_select_db($database_news, $news);
  $Result1 = mysql_query($updateSQL, $news) or die(mysql_error());

  $updateGoTo = "index.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
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
        <form action="<?php echo $editFormAction; ?>" id="form1" name="form1" method="POST">
          <table width="90%" align="center">
            <tr>
              <th colspan="2" align="left"> 編輯新聞</th>
            </tr>
            <tr>
              <td width="20%" valign="baseline"><strong>分類</strong></td>
              <td valign="baseline"><select name="news_type" id="news_type" title="<?php echo $row_Recordset1['news_type']; ?>">
                <option value="公告" selected="selected" <?php if (!(strcmp("公告", $row_Recordset1['news_type']))) {echo "selected=\"selected\"";} ?>>公告</option>
                <option value="活動" <?php if (!(strcmp("活動", $row_Recordset1['news_type']))) {echo "selected=\"selected\"";} ?>>活動</option>
                <option value="更新" <?php if (!(strcmp("更新", $row_Recordset1['news_type']))) {echo "selected=\"selected\"";} ?>>更新</option>
                <option value="其他" <?php if (!(strcmp("其他", $row_Recordset1['news_type']))) {echo "selected=\"selected\"";} ?>>其他</option>
              </select>
              <input name="news_id" type="hidden" id="news_id" value="<?php echo $row_Recordset1['news_id']; ?>" /></td>
            </tr>
            <tr>
              <td valign="baseline"><strong>標題</strong></td>
              <td valign="baseline"><input name="news_subject" type="text" id="news_subject" value="<?php echo $row_Recordset1['news_subject']; ?>" size="45" /></td>
            </tr>
            <tr>
              <td valign="baseline"><strong>日期</strong></td>
              <td valign="baseline"><input name="news_date" type="text" id="news_date" value="<?php echo $row_Recordset1['news_date']; ?>" /></td>
            </tr>
            <tr>
              <td valign="baseline"><strong>編輯者</strong></td>
              <td valign="baseline"><input name="news_editor" type="text" id="news_editor" value="<?php echo $row_Recordset1['news_editor']; ?>" /></td>
            </tr>
            <tr>
              <td valign="baseline"><strong>內容</strong></td>
              <td valign="baseline"><textarea name="news_content" id="news_content" cols="60" rows="15"><?php echo $row_Recordset1['news_content']; ?></textarea></td>
            </tr>
            <tr>
              <td valign="baseline"><strong>審核</strong></td>
              <td valign="baseline"><input <?php if (!(strcmp($row_Recordset1['news_ok'],"No"))) {echo "checked=\"checked\"";} ?>  name="news_ok" type="radio" id="news_ok" value="<?php echo $row_Recordset1['news_ok']; ?>" checked="checked" />
                審核中
                <input <?php if (!(strcmp($row_Recordset1['news_ok'],"Yes"))) {echo "checked=\"checked\"";} ?>  type="radio" name="news_ok" id="news_ok2" value="Yes" />
                已通過</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td><input type="submit" name="button" id="button" value="送出" />
              <input type="reset" name="button2" id="button2" value="重設" />
              <input type="button" name="button3" id="button3" value="回主頁面" onclick="window.location='admin.php'" /></td>
            </tr>
          </table>
          <input type="hidden" name="MM_update" value="form1" />
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
