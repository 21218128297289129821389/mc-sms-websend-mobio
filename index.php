<?php
date_default_timezone_set('Europe/Sofia'); //Задаваме времева зона
$starttime = explode(' ', microtime());		//Стартираме
$starttime = $starttime[1] + $starttime[0];	//Микротаймера

$errormsg = '';

//Настройки
$siteTitle = "PHP-Example-for-Websend-and-Minecraft-Server-with-Mobio.BG"; //Име на сайта

$siteDescription = "PHP-Example-for-Websend-and-Minecraft-Server-with-Mobio.BG"; //Description

$siteAuthor = "TheEVILbg"; //Автор на сайта

$siteNavTextTitle = "Смс система с mobio.bg и websend за minecraft"; //Текста на шапката

//---/

$servID = 26130; //ID на услуга от Mobio.bg

$smsSendInfo = "Изпрати смс на номер 0000 с текст TXTTT на цена 6.00лв с ДДС!"; //Информация за изпращане на смс-а

//Функция за връзка с mobio.bg
function mobio_checkcode($servID, $code, $debug=0) {
	
	$res_lines = file("http://www.mobio.bg/code/checkcode.php?servID=$servID&code=$code");
	
	$ret = 0;
	if($res_lines) {
		
		if(strstr("PAYBG=OK", $res_lines[0])) {
			$ret = 1;
			}else{
			if($debug)
			echo $line."\n";
		}
		}else{
		if($debug)
		echo "Unable to connect to mobio.bg server.\n";
		$ret = 0;
	}
	
	return $ret;
}

//Заявката
if(isset($_POST['submit']))
{
	$code = trim($_POST['code']);
	$playername = htmlspecialchars(addslashes($_POST['playername']));
	$usergroup = htmlspecialchars(addslashes($_POST['usergroup']));
	
	 if(mobio_checkcode($servID, $code, 0) == 1) {
		 if($playername==NULL )
		 {
		$errormsg = '<div class="alert alert-danger" role="alert">Попълнете всички полета!</div>'; //Ако полетата са празни изписва това.
		 }else{
		//some more script...
		$errormsg = '<div class="alert alert-success" role="alert">Честито групата е активирана!</div>'; //Активирана група...
		 }
	 }else{
		$errormsg = '<div class="alert alert-danger" role="alert">СМС КОДА Е ГРЕШЕН! Опитай отново!</div>'; //Ако кода е грешен изписва това.
	 }
}
?>
<!DOCTYPE html>
<html lang="bg">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="<?php echo $siteDescription; ?>">
    <meta name="author" content="<?php echo $siteAuthor; ?>">
    <link rel="icon" href="http://getbootstrap.com/favicon.ico">

    <title><?php echo $siteTitle; ?></title>

    <!-- Bootstrap core CSS -->
    <link href="http://getbootstrap.com/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="http://getbootstrap.com/examples/jumbotron-narrow/jumbotron-narrow.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="http://getbootstrap.com/assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="http://getbootstrap.com/assets/js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <div class="container">
      <div class="header clearfix">
        <nav>
          <ul class="nav nav-pills pull-right">
            <li role="presentation" class="active"><a href="/">Начало</a></li>
          </ul>
        </nav>
        <h3 class="text-muted"><?php echo $siteNavTextTitle; ?></h3>
      </div>

  

      <div class="row marketing">
    <div class="alert alert-warning" role="alert"><?php echo $smsSendInfo; ?></div>

        <form method="post" action="">
        
		<div class="form-group">
			<label for="playername">Minecraft име <font color="red">*</font></label>
			<input type="text" class="form-control" id="playername" placeholder="Въведи точно името си от сървъра!">
		</div>
		
		<div class="form-group">
			<label for="usergroup">Избери ранг <font color="red">*</font></label>
			
		<select class="form-control" id="usergroup">
			<option value="MegaUser">MegaUser</option>
			<option value="SuperUser">SuperUser</option>
		</select>
		
		</div>
		
		<div class="form-group">
    		<label for="smscode">СМС Код <font color="red">*</font></label>
    		<input type="text" class="form-control" id="code" placeholder="Въведи смс кода който получи!">
		</div>
		
  		<input type="submit" class="btn btn-default" name="submit" value="Изпълни" />

		</form>
		
	<br />
	
	<?php echo $errormsg; ?>
      </div>

      <footer class="footer">
        <p>&copy; <span style="float:right;"><?php $mtime = explode(' ', microtime());$totaltime = $mtime[0] + $mtime[1] - $starttime;printf('Страницата се генерира за %.3f секунди.', $totaltime); //показваме микротаймера?></span></p>
      </footer>

    </div> <!-- /container -->


    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="http://getbootstrap.com/assets/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>