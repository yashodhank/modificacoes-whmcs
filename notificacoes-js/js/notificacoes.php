<?php
	$audio = "//url-do-mp3.com.br/audio.mp3";
	$whmcs_url = "//painelwhmcs.com.br/pasta/"; //Mantenha a barra (/) no final
	if(isset($_GET['u']) && isset($_GET['e']))
	{
		require_once("../../../configuration.php");
		$md5 = md5($_GET['e'].$autoauthkey);
		if($md5 == $_GET['u'])
		{
		echo "var md5cli = '".$md5."';";
?>
$(document).ready(function() {
	var icones = {ok:"//i.imgur.com/mqL8Az3.png", novo:"//i.imgur.com/5rMHaTV.png"};
	var carregado = false;
	function notificar(texto,icone,titulo,url) {
		var options = {
			body: texto,
			icon: icone
		}
		var n = new Notification(titulo,options);
		$("#audio-notificacao").remove();
		$("body").append('<audio autoplay id="audio-notificacao"><source src="<?=$audio?>" type="audio/mpeg"></audio>');
		setTimeout(n.close.bind(n), 5000);
		if(url != null)
		{
			n.onclick = function(event) {
				event.preventDefault();
				window.location=url;
			}
		}
	}
	if (!("Notification" in window)) {
		alert("Esse navegador não suporta notificações");
	}
	else if (Notification.permission !== 'denied') {
		Notification.requestPermission(function(){carregado=true;});
	}
	setInterval(function(){
		if(carregado === true)
		{
			$.get("<?=$whmcs_url?>notificacoes.php?u=<?=$_GET['u']?>&e=<?=$_GET['e']?>", function(data) {
				for (i = 0; i < data.length; i++) {
					notificar(data[i].texto, icones[data[i].icone], data[i].titulo, data[i].url);
				}
			});
		}
	},5000);
});
<?php
	}
	}
?>
