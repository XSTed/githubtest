<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>無標題文件</title>
</head>

<body>
<form action="add.php" method="post" enctype="multipart/form-data" name="form1" id="form1">
  <table width="600" border-collapse="collapse" align="center">
    <tbody>
      <tr>
        <td colspan="2"><label for="fileField">請選擇上傳檔案：</label></td>
      </tr>
      <tr>
        <td width="300">
        <input name="myfile" type="file" multiple="multiple" id="myfile"></td>
        <td width="300"><input type="submit" name="submit" id="submit" value="送出"></td>
      </tr>
    </tbody>
  </table>
</form>
	<table width="600" border="1" align="center">
  <tbody>
    <tr>
      <td style="text-align: center"><a href="index.php">回首頁</a></td>
    </tr>
  </tbody>
</table>

</body>
</html>