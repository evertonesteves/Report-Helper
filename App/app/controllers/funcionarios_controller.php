<?php
/**
* 
*/
class FuncionariosController extends AppController
{
	var $helpers = array("Report");
	
	function listar_funcionarios()
	{
		$this->set('funcionarios', $this->Funcionario->findAll());
	}
}

?>