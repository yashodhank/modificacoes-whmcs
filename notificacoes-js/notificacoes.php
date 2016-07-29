<?php
	$whmcs_url = "http://whmcspainel.com.br/pasta/"; // Você deve manter a barra (/) no final.
	header('Content-Type: application/json');
    class Database
    {
        private static $instance = null;
        public static function conectar($cfhost, $cfuser, $cfsenha, $cfdb, $cftype = 'mysql', $cfps = false) 
        {
            if($cfps != FALSE){$cfps = TRUE;}
            if(!isset(self::$instance))
            {
                try
                {
                    self::$instance = new \PDO($cftype . ':host=' . $cfhost . ';dbname=' . $cfdb, $cfuser, $cfsenha, array(\PDO::ATTR_PERSISTENT => $cfps));
                }
                catch (\PDOException $ex) 
                {
                    exit("Erro ao conectar com o banco de dados: " . $ex->getMessage());
                }
            }
            self::$instance->query("SET NAMES 'utf8'; SET character_set_connection=utf8; SET character_set_client=utf8; SET character_set_results=utf8;");
            return self::$instance;
        }
        public static function desconectar() 
        {
            if (self::$instance != null){self::$instance = null;}
        }
    }
	if(isset($_GET['u']))
	{
		require_once("configuration.php");
		session_start();
		if(!isset($_SESSION['tckid']))
		{
			$_SESSION['tckid'] = array();
		}
		$db = Database::conectar($db_host,$db_username,$db_password,$db_name);
		$qc = $db->query("SELECT * FROM tblclients WHERE email = '".$_GET['e']."';");
		$rc = $qc->fetch();
		$resultado = array();
		if($qt = $db->query("SELECT * FROM tbltickets WHERE userid = '".$rc['id']."' AND status = 'Answered';"))
		{
			while($rt = $qt->fetch())
			{
				if(isset($_SESSION['tckid'][$rt['id']]))
				{
					if($_SESSION['tckid'][$rt['id']] != $rt['lastreply'])
					{
						$resultado[count($resultado)] = array('texto' => 'O ticket '.$rt['title'].' foi respondido.', 'icone' => 'novo', 'titulo' => 'Nova resposta', 'url' => $whmcs_url.'viewticket.php?tid='.$rt['tid'].'&c='.$rt['c']);
						$_SESSION['tckid'][$rt['id']] = $rt['lastreply'];
					}
				}
				else {
					$resultado[0] = array('texto' => 'O ticket '.$rt['title'].' foi respondido.', 'icone' => 'novo', 'titulo' => 'Nova resposta', 'url' => $whmcs_url.'viewticket.php?tid='.$rt['tid'].'&c='.$rt['c']);
					$_SESSION['tckid'][$rt['id']] = $rt['lastreply'];
				}
			}
		}
		if(isset($resultado[0]))
		{
			echo json_encode($resultado);
		}
	}
?>
