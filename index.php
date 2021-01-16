<?php


if(!empty($_POST['php_code'])){

	// Submitted Code
	$php = $_POST['php_code'];
	
	// Deobfuscate
	$deobfCode = htmlspecialchars(deobf($php));

}


function deobf($phpcode){

	$obfPHP = $phpcode;

	$phpcode = base64_decode(getTextInsideQuotes(getEvalCode($phpcode)));

	$hexvalues = getHexValues($phpcode);

	$pointer1 = hexdec(getHexValues($obfPHP)[0]);
	$pointer2 = hexdec($hexvalues[0]);
	$pointer3 = hexdec($hexvalues[1]);

	$needles = getNeedles($phpcode);

	$needle = $needles[count($needles) - 2];
	$before_needle = end($needles);
	
	
	$phpcode = base64_decode(strtr(substr($obfPHP, $pointer2 + $pointer3, $pointer1), $needle, $before_needle));

	return "<?php {$phpcode} ?>";

}


function getEvalCode($string){
	preg_match("/eval\((.*?)\);/", $string, $matches);

	return (empty($matches)) ? '' : end($matches);
}


function getTextInsideQuotes($string){
	preg_match("/\('(.*?)'\)/", $string, $matches);

	return (empty($matches)) ? '' : end($matches);
}

function getNeedles($string){
	preg_match_all("/'(.*?)'/", $string, $matches);
	
	return (empty($matches)) ? array() : $matches[1];
}


function getHexValues($string){
	preg_match_all('/0x[a-fA-F0-9]{1,8}/', $string, $matches);

	return (empty($matches)) ? array() : $matches[0];
}


?>


<!DOCTYPE html>
<html>
	<body style="background-color:black;">
<body>
  <p style="color:#FFFFFF";>JUST PASTE CODE AND DECODE</p>
</body>
<body>

	Paste PHP LockIt! v2.2 obfuscated code: <br>

<form action="" method="POST">
	<textarea name="php_code" style="width: 430px;height: 300px;"><?=isset($deobfCode) ? $deobfCode : ''?></textarea><br><br>
	<input type="submit" value="Deobfuscate">
</form>

)

</body>
</html>
