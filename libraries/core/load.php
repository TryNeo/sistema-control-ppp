<?php 
	$controller = ucwords($controller);
	$controllerFile = "Controllers/".$controller.".php";
	if(file_exists($controllerFile))
	{
		require_once($controllerFile);
		$controller = str_replace("-", "", $controller);
		$controller = new $controller();
		$method = str_replace("-", "", $method);;
		if(method_exists($controller, $method))
		{
			$controller->{$method}($params);
		}else{
			require_once("Controllers/Error.php");
		}
	}else{
		require_once("Controllers/Error.php");
	}

?>