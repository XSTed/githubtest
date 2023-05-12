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

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_Recordset1 = 10;
$pageNum_Recordset1 = 0;
if (isset($_GET['pageNum_Recordset1'])) {
  $pageNum_Recordset1 = $_GET['pageNum_Recordset1'];
}
$startRow_Recordset1 = $pageNum_Recordset1 * $maxRows_Recordset1;

mysql_select_db($database_news, $news);
$query_Recordset1 = "SELECT * FROM newscenter ORDER BY news_date DESC";
$query_limit_Recordset1 = sprintf("%s LIMIT %d, %d", $query_Recordset1, $startRow_Recordset1, $maxRows_Recordset1);
$Recordset1 = mysql_query($query_limit_Recordset1, $news) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);

if (isset($_GET['totalRows_Recordset1'])) {
  $totalRows_Recordset1 = $_GET['totalRows_Recordset1'];
} else {
  $all_Recordset1 = mysql_query($query_Recordset1);
  $totalRows_Recordset1 = mysql_num_rows($all_Recordset1);
}
$totalPages_Recordset1 = ceil($totalRows_Recordset1/$maxRows_Recordset1)-1;

mysql_select_db($database_news, $news);
$query_Recordset2 = "SELECT * FROM newsadmin";
$Recordset2 = mysql_query($query_Recordset2, $news) or die(mysql_error());
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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>新聞資料管理系統</title>
<link href="style.css" rel="stylesheet" type="text/css" media="screen" />
</head>

<body>
<div id="warp">
  <div id="header">
    <div class="topfunction"><a href="index.php" title="回到首頁"><img src="images/House.png" alt="回到首頁" width="32" height="32" /></a><a href="login.php" title="登入管理介面" target="main"><img src="images/Lock.png" alt="登入管理介面" width="32" height="32" /></a></div>
    <div class="logo"><img src="images/DWonline.png" width="180" height="40" alt="dreamweaver.com.tw" /></div>
  </div>
  <div class="contentcontainer">
    <div class="headings altheading">
      <h2>新聞系統</h2>
    </div>  
    <div class="contentbox">
    	<!-- Status Bar Start --><!-- Status Bar End -->
        
         <!-- Red Status Bar Start --><!-- Red Status Bar End -->
        
        <!-- Green Status Bar Start --><!-- Green Status Bar End -->
        
        <!-- Blue Status Bar Start --><!-- Blue Status Bar End -->
      <?php if ($totalRows_Recordset1 == 0) { // Show if recordset empty ?>
  <div class="status warning">
    <p><img src="images/icon_warning.png" alt="Warning" /><span>注意</span> 目前新聞資料庫中並沒有任何資料！</p>
  </div>
  <?php } // Show if recordset empty ?>
<table width="100%">
          <tr>
              <th align="left">分類</th>
              <th align="left">標題</th>
              <th align="left">時間</th>
              <th align="left">點閱</th>
        </tr>
            <?php do { ?>
              <tr class="alt">
                <td><div class="typeblock">&nbsp;<?php echo $row_Recordset1['news_type']; ?></div></td>
                <td></a> <?php /*start db_input script*/ if ($row_Recordset1['news_date'] == date("Y-m-d")){ ?>
                    <img src="images/new.gif" width="28" height="11" />
                    <?php } /*end db_input script*/ ?>
                <a href="detail.php?id=<?php echo $row_Recordset1['news_id']; ?>&amp;countok=true"><?php echo $row_Recordset1['news_subject']; ?></a></td>
                <td><?php echo $row_Recordset1['news_date']; ?></td>
                <td><?php echo $row_Recordset1['news_hits']; ?></td>
              </tr>
              <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
      </table>
          <div class="extrabottom">
            <table width="100%" border="0" cellpadding="0" cellspacing="0" class="simpletb">
              <tr>
                <td align="left">&nbsp;
記錄 <?php echo ($startRow_Recordset1 + 1) ?> 到 <?php echo min($startRow_Recordset1 + $maxRows_Recordset1, $totalRows_Recordset1) ?> 共 <?php echo $totalRows_Recordset1 ?></td>
                <td align="right">&nbsp;
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
<div id="footer">&copy; Copyright 2012 eHappy Studio 織夢新聞系統</div>
    </div>
  </div>
</div>
</body>
</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset2);
?>
