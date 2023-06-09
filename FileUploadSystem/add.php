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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO upload (UserFilename, ServerFilename, `Size`, `Comment`) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['UserFilename'], "text"),
                       GetSQLValueString($_POST['ServerFilename'], "text"),
                       GetSQLValueString($_POST['Size'], "text"),
                       GetSQLValueString($_POST['Comment'], "text"));

  mysql_select_db($database_cnupload, $cnupload);
  $Result1 = mysql_query($insertSQL, $cnupload) or die(mysql_error());

  $insertGoTo = "index.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

	echo "檔案名稱：".$_FILES['myfile']['name']."<br>";
	echo "檔案大小：".$_FILES['myfile']['size']."<br>";
	echo "檔案格式：".$_FILES['myfile']['type']."<br>";
	echo "暫存名稱：".$_FILES['myfile']['tmp_name']."<br>";
	echo "錯誤代碼：".$_FILES['myfile']['error']."<br>";

if($_FILES['myfile']['error'] > 0)
{
   switch($_FILES['myfile']['error'])
  {
     case 1 : die("檔案大小超出 php.ini:upload_max_filesize 限制");
     case 2 : die("檔案大小超出 MAX_FILE_SIZE 限制");
     case 3 : die("檔案僅被部分上傳");
     case 4 : die("檔案未被上傳");
  }
}
if(is_uploaded_file($_FILES['myfile']['tmp_name']))
{
   $DestDIR = "files";
   if(!is_dir($DestDIR) || !is_writeable($DestDIR))
         die("目錄不存在或無法寫入");

  $File_Extension = explode(".", $_FILES['myfile']['name']); 
  $File_Extension = $File_Extension[count($File_Extension)-1]; 
  $ServerFilename =date("YmdHis") . "." . $File_Extension;
move_uploaded_file($_FILES['myfile']['tmp_name'] , $DestDIR . "/" . $ServerFilename );
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>無標題文件</title>
</head>

<body>
<form action="<?php echo $editFormAction; ?>" id="form1" name="form1" method="POST">
  <table width="600" border-collapse="collapse" align="center">
    <tbody>
      <tr>
        <td width="240">檔案名稱</td>
        <td width="360">
        <input name="UserFilename" type="text" id="UserFilename" value="<?php echo $_FILES['myfile']['name'];?>" size="40"></td>
      </tr>
      <tr>
        <td>檔案大小</td>
        <td>
        <input name="Size" type="text" id="Size" value="<?php echo $_FILES['myfile']['size'];?>" size="40"></td>
      </tr>
      <tr>
        <td height="84">檔案註解</td>
        <td>
        <textarea name="Comment" cols="60" rows="9" id="Comment"></textarea></td>
      </tr>
      <tr>
        <td><input name="ServerFilename" type="hidden" id="ServerFilename" value="<?php echo $ServerFilename;?>"></td>
        <td style="text-align: right"><input type="submit" name="submit" id="submit" value="送出"></td>
      </tr>
    </tbody>
  </table>
  <input type="hidden" name="MM_insert" value="form1">
</form>
</body>
</html>