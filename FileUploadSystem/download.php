<?php
$Filename="files/" . $_GET['ServerFilename'];  //設定路徑
	if(!file_exists($Filename)){
		header ('Content-type: text/html; charset=utf-8');
		die("檔案不存在");
	}
		
	header('Content-type: application/force-download');
	header('Content-Transfer-Encoding: Binary');
	header("Content-Disposition: attachment; filename=". iconv("utf-8", "big5", $_GET['UserFilename'])); //設定下載檔名
	readfile($Filename);  //下載檔案

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>無標題文件</title>
</head>

<body>
</body>
</html>