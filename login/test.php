<?php
$from = 'admin@dailytoast.dx.am';
$to = 'august_danny@yahoo.co.id';
$subject = 'Hi!';
$body = 'TEST';

if(mail($to,$subject,$body,$from)){
	echo 'MAIL – OK';
}else{
	echo 'MAIL FAILED';
}

?>