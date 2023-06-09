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

$colname_Recordset1 = "-1";
if (isset($_GET['id'])) {
    $colname_Recordset1 = $_GET['id'];
}
mysql_select_db($database_student, $student);
$query_Recordset1 = sprintf("SELECT * FROM stud WHERE stud_id = %s", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $student) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

if ((isset($_GET['count'])) && ($_GET['count'] != "")) {
    $execSQL = "UPDATE stud SET stud_hits=stud_hits+1 WHERE stud_id=" . $_GET['id'];

    mysql_select_db($database_student, $student);
    $Result1 = mysql_query($execSQL, $student) or die(mysql_error());

    $execGoTo = "detail.php?id=" . $_GET['id'];
    header(sprintf("Location: %s", $execGoTo));
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>無標題文件</title>
</head>

<body>
    <table width="904" border="1" align="center" cellpadding="0" cellspacing="0">
        <tr bgcolor="#8B0000">
            <td height="90" colspan="2" align="center" valign="middle"><span style="color: #FFF; font-weight: bolder; font-size: 48px; font-family: '標楷體';">學員資料管理系統</span></td>
        </tr>
        <tr>
            <td width="200" height="120" align="center">相片</td>
            <td width="498" height="150" align="center"><img src="images/<?php echo $row_Recordset1['stud_photo']; ?>" width="150" height="150" /></td>
        </tr>
        <tr>
            <td width="200" height="30" align="center">姓名</td>
            <td height="30"><?php echo $row_Recordset1['stud_name']; ?></td>
        </tr>
        <tr>
            <td width="200" height="30" align="center">性別</td>
            <td height="30"><?php echo $row_Recordset1['stud_sex']; ?></td>
        </tr>
        <tr>
            <td width="200" height="30" align="center">出生日期</td>
            <td height="30"><?php echo $row_Recordset1['stud_birthday']; ?></td>
        </tr>
        <tr>
            <td width="200" height="30" align="center">身分證字號</td>
            <td height="30"><?php echo $row_Recordset1['stud_idno']; ?></td>
        </tr>
        <tr>
            <td width="200" height="30" align="center">畢業學校</td>
            <td height="30"><?php echo $row_Recordset1['stud_school']; ?></td>
        </tr>
        <tr>
            <td width="200" height="30" align="center">科系</td>
            <td height="30"><?php echo $row_Recordset1['stud_major']; ?></td>
        </tr>
        <tr>
            <td width="200" height="30" align="center">行動電話</td>
            <td height="30"><?php echo $row_Recordset1['stud_phone']; ?></td>
        </tr>
        <tr>
            <td width="200" height="30" align="center">地址</td>
            <td height="30"><?php echo $row_Recordset1['stud_address']; ?></td>
        </tr>
        <tr>
            <td width="200" height="30" align="center">簡歷資料(附件檔)</td>
            <td height="45" align="center">
                <p><a href="<?php echo '學員簡歷/' . $row_Recordset1['appendix']; ?>" <?php echo "download"; ?>><?php echo $row_Recordset1['appendix']; ?></a></p><a href="index.html" target="_top">回首頁</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href="index.php">回上一頁</a>
            </td>
        </tr>
    </table>
</body>

</html>
<?php
mysql_free_result($Recordset1);
?>