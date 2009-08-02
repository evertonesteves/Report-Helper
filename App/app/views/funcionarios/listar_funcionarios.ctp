<?php
$campos = array(
	"Funcionario" => array("field"=>"Funcionario.nome"),
	"Telefone" => array("field"=>"Funcionario.telefone"),
	"Data de Nascimento" => array("field"=>"Funcionario.nascimento", "type"=>"data"),
	"editar"=>array("text"=>"editar", "link" => "funcionarios/editar/Funcionario.id"),
	"excluir"=> array("text"=>"excluir", "link"=>"funcionarios/excluir/Funcionario.id")
	);
echo $report->show($funcionarios, $campos,"Nenhum funcionário foi encontrado!");	
?>