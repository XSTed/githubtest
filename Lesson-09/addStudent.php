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
        "INSERT INTO stud (stud_id, stud_name, stud_idno, stud_sex, stud_birthday, stud_school, stud_major, stud_phone, stud_address, stud_photo) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
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
$query_Recordset1 = "SELECT * FROM stud";
$Recordset1 = mysql_query($query_Recordset1, $student) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>無標題文件</title>
</head>

<body>
    <form id="form1" name="form1" method="POST" action="<?php echo $editFormAction; ?>">
        <table width="984" border="1" align="center" cellpadding="0" cellspacing="0">
            <tr>
                <td height="200" colspan="2" align="center"><img src="images/nice1.gif" width="600" height="315" /></td>
            </tr>
            <tr>
                <td width="200" height="30" align="center">學號</td>
                <td height="30"><label for="stud_id"></label>
                    &nbsp; <input type="text" name="stud_id" id="stud_id" /></td>
            </tr>
            <tr>
                <td width="200" height="30" align="center">姓名</td>
                <td height="30"><label for="stud_name"></label>
                    &nbsp; <input type="text" name="stud_name" id="stud_name" /></td>
            </tr>
            <tr>
                <td width="200" height="30" align="center">性別</td>
                <td height="30"><input type="radio" name="stud_sex" id="radio" value="M" />
                    男
                    <input type="radio" name="stud_sex" id="radio2" value="F" />
                    <label for="stud_sex">女</label>
                </td>
            </tr>
            <tr>
                <td width="200" height="30" align="center">出生日期</td>
                <td height="30"><label for="stud_birthday"></label>
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
                <td width="200" height="30" align="center">身分證字號</td>
                <td height="30"><label for="stud_idno">&nbsp; </label>
                    <input type="text" name="stud_idno" id="stud_idno" />
                </td>
            </tr>
            <tr>
                <td width="200" height="30" align="center">畢業學校</td>
                <td height="30"><label for="stud_school">&nbsp; </label>
                    <input type="text" name="stud_school" id="stud_school" />
                </td>
            </tr>
            <tr>
                <td width="200" height="30" align="center">科系</td>
                <td height="30"><label for="stud_major">&nbsp; </label>
                    <input type="text" name="stud_major" id="stud_major" />
                </td>
            </tr>
            <tr>
                <td width="200" height="30" align="center">行動電話</td>
                <td height="30"><label for="stud_phone">&nbsp; </label>
                    <input type="text" name="stud_phone" id="stud_phone" />
                </td>
            </tr>
            <tr>
                <td width="200" height="30" align="center">地址</td>
                <td height="30"><label for="stud_address">&nbsp; </label>
                    <input type="text" name="stud_address" id="stud_address" />
                </td>
            </tr>
            <tr>
                <td width="200" height="30" align="center">相片</td>
                <td height="30"><label for="stud_photo">&nbsp; </label>
                    <input type="text" name="stud_photo" id="stud_photo" />
                </td>
            </tr>
            <tr>
                <td height="25" colspan="2" align="center"><input type="submit" name="button" id="button" value="送出" />
                    &nbsp;&nbsp; <input type="reset" name="button2" id="button2" value="重設" /></td>
            </tr>
        </table>
        <input type="hidden" name="MM_insert" value="form1" />
    </form>
</body>

</html>
<?php
mysql_free_result($Recordset1);
?>