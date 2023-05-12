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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form")) {
  $insertSQL = sprintf("INSERT INTO reply (Reply_TopicID, Content, Nickname, Email, `Time`) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['Reply_TopicID'], "int"),
                       GetSQLValueString($_POST['Content'], "text"),
                       GetSQLValueString($_POST['Nickname'], "text"),
                       GetSQLValueString($_POST['Email'], "text"),
                       GetSQLValueString($_POST['Time'], "date"));

  mysql_select_db($database_forum, $forum);
  $Result1 = mysql_query($insertSQL, $forum) or die(mysql_error());

  $insertGoTo = "topic.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
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
	<form action="<?php echo $editFormAction; ?>" name="form" method="POST"><table width="900" border="0" align="center">
  <tbody>
    <tr>
      <td width="450">
        <label for="textfield">暱稱:</label>
        <input type="text" name="Nickname" id="Nickname"></td>
      <td width="440">
        <label for="textfield2">EMail:</label>
        <input type="text" name="Email" id="Email"></td>
    </tr>
    <tr>
      <td colspan="2">
        <textarea name="Content" cols="100" rows="15" id="Content"></textarea></td>
      </tr>
    <tr>
      <td colspan="2"><input name="Time" type="hidden" id="Time" value="<?php echo date("Y:m:d H:i:s"); ?>">
        <input type="submit" name="submit" id="submit" value="送出">
        <input name="Reply_TopicID" type="hidden" id="Reply_TopicID" value="<?php echo $_GET['TopicID']; ?>"></td>
      </tr>
  </tbody>
</table>
	  <input type="hidden" name="MM_insert" value="form">
</form>
</body>
</html>