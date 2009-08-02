<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Screencast</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <?
    if (is_file(APP.WEBROOT_DIR.DS ."css".DS.$this->params["controller"].DS.$this->params["action"].".css")){
        echo $html->css($this->params["controller"]."/".$this->params["action"]);
    }
    ?>

</head>

<body>
	<div>
		<?=$content_for_layout?>
	</div>
</body>
</html>