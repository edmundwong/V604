<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>加拿大</title>
<script>
	function myClick(){
		var dom_click = document.getElementById('myClick');
		dom_click.click();
	}
	setTimeout(myClick,5000);
</script>
</head>

<body>
<a id='myClick' href='javascript:alert(111);'>test</a>
<?php
$s_str = "联系地址";
echo mb_substr($s_str,0,4,'utf-8');
echo "<br/> $s_str";
?>

</body>
</html>