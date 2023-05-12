<?php require_once('Connections/student.php'); ?>
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
    $insertSQL = sprintf(
        "INSERT INTO student (stud_id, stud_name, stud_idno, stud_sex, stud_birthday, stud_school, stud_major, stud_phone, stud_address, stud_photo) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
        GetSQLValueString($_POST['stud_id'], "int"),
        GetSQLValueString($_POST['stud_name'], "text"),
        GetSQLValueString($_POST['stud_idno'], "text"),
        GetSQLValueString($_POST['stud_sex'], "text"),
        GetSQLValueString($_POST['stud_birthday'], "date"),
        GetSQLValueString($_POST['stud_school'], "text"),
        GetSQLValueString($_POST['stud_major'], "text"),
        GetSQLValueString($_POST['stud_phone'], "text"),
        GetSQLValueString($_POST['stud_address'], "text"),
        GetSQLValueString($_POST['stud_photo'], "text")
    );

    mysql_select_db($database_student, $student);
    $Result1 = mysql_query($insertSQL, $student) or die(mysql_error());

    $insertGoTo = "index.php";
    if (isset($_SERVER['QUERY_STRING'])) {
        $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
        $insertGoTo .= $_SERVER['QUERY_STRING'];
    }
    header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_student, $student);
$query_Recordset1 = "SELECT * FROM student";
$Recordset1 = mysql_query($query_Recordset1, $student) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>無標題文件</title>
    <style>
        input {
            height: 30px;
            margin-left: 5px;
        }

        input #button {
            border-radius: 5px;
        }
    #form1 table {
	color: #FFF;
	font-weight: bold;
}
    #form1 table tr td label {
	color: #000;
}
    body {
	background-color: #FFC;
}
    </style>
</head>

<body>
<div align="center">
        <form id="form1" name="form1" method="POST" action="<?php echo $editFormAction; ?>">
          <table width="900" border="1" cellspacing="0" cellpadding="0">
                <tr>
                    <td height="250" colspan="2" align="center" valign="middle"><img src="images/addCat.gif" width="320" height="240" title="addCat" /></td>
                </tr>
                <tr>
                    <td width="200" height="40" align="center" valign="middle" bgcolor="#3399FF">學號</td>
                    <td><label for="stud_id"></label>
                        <input type="text" name="stud_id" id="stud_id" size="15" />
                  </td>
            </tr>
                <tr>
                    <td height="40" align="center" valign="middle" bgcolor="#3399FF">姓名</td>
                    <td><label for="stud_name"></label>
                        <input type="text" name="stud_name" id="stud_name" size="20" />
                  </td>
            </tr>
                <tr>
                    <td height="40" align="center" valign="middle" bgcolor="#3399FF">性別</td>
                    <td><input type="radio" name="stud_sex" id="radio" value="M" checked="checked" />
                        <label for="stud_sex">男</label>
                        <input type="radio" name="stud_sex" id="radio2" value="F" /><label for="stud_sex">女</label>
                  </td>
            </tr>
                <tr>
                    <td height="40" align="center" valign="middle" bgcolor="#3399FF">出生日期</td>
                    <td><label for="stud_birthday"></label>
                        <link rel="stylesheet" href="http://code.jquery.com/ui/1.9.0/themes/base/jquery-ui.css" />
                        <script src="http://code.jquery.com/jquery-1.8.2.js"></script>
                        <script src="http://code.jquery.com/ui/1.9.0/jquery-ui.js"></script>&nbsp;
                        <script>
                            $(function() {
                                $("#stud_birthday").datepicker({
                                    dateFormat: 'yy-mm-dd'
                                });
                            });
                        </script><input type="text" name="stud_birthday" id="stud_birthday" />
                  </td>
            </tr>
                <tr>
                    <td height="40" align="center" valign="middle" bgcolor="#3399FF">身分證號</td>
                  <td><input type="text" name="stud_idno" id="stud_idno" size="30" /></td>
            </tr>
                <tr>
                    <td height="40" align="center" valign="middle" bgcolor="#3399FF">畢業學校</td>
                  <td><input type="text" name="stud_school" id="stud_school" size="50" /></td>
            </tr>
                <tr>
                    <td height="40" align="center" valign="middle" bgcolor="#3399FF">科系</td>
                  <td><input type="text" name="stud_major" id="stud_major" size="50" /></td>
            </tr>
                <tr>
                    <td height="40" align="center" valign="middle" bgcolor="#3399FF">行動電話</td>
                  <td><input name="stud_phone" type="text" id="stud_phone" size="20" /></td>
            </tr>
                <tr>
                    <td height="40" align="center" valign="middle" bgcolor="#3399FF">地址</td>
                  <td><input type="text" name="stud_address" id="stud_address" size="80" /></td>
            </tr>
                <tr>
                    <td height="40" align="center" valign="middle" bgcolor="#3399FF">相片</td>
                  <td><input type="text" name="stud_photo" id="stud_photo" size="30" /></td>
            </tr>
                <tr bgcolor="#FFCCFF">
                    <td height="40" colspan="2" align="center" valign="middle"><input type="submit" name="button" id="button" value="送出" />
                        &nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="reset" name="button2" id="button2" value="重設" />
                    </td>
                </tr>
          </table>
            <input type="hidden" name="MM_insert" value="form1" />
  </form>
</div>
</body>

</html>
<?php
mysql_free_result($Recordset1);
?>