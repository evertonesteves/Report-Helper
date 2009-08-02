<?php
/*************************************************************************************
Helper para montar tela de relatório utilizando o framework CakePHP
Desenvolvido por Alberto Leal - albertonb@gmail.com
Atualizado por Carlos Spineli

## Forma de Utilização:

	$campos = array(
		"Label do Campo"=>"Model.nome_do_campo",
		"editar"=>array("text"=>"editar","link"=>"/.../Model.id"),
		"excluir"=>array("text"=>"excluir","link"=>"/.../Model.id")
	);
	echo $report->show($dados,$campos,"mensagem", $paginate);
**************************************************************************************/ 
class ReportHelper extends Helper {
	
	var $helpers = array("Form","Html","Time","Number");

	function show($dados,$campos,$empty=null, $paginacao=null){
			
		if(!empty($dados)){
				$view = $this->table($dados,$campos);
				if(!is_null($paginacao)){
					$view .= $this->paginacao($paginacao);
				}
		}
		else{
			!is_null($empty) ? $msg = $empty : $msg = "nenhum registro encontrado";
    		$view = '<p class="vazio">'.$msg.'</p>';
    	}
		
		return $view;
	}

	function table($dados,$campos){
		$table = "<table><thead><tr>"; 
		foreach ($campos as $key => $value){
			if(is_array($value) && isset($value["link"]) && isset($value["text"])){
				$table .= '<th id="th'.$value["text"].'">'.$value["text"].'</th>';
			}
			else{
				$table .= "<th>".$key."</th>";
			}
		}
		$table.="</tr></thead><tbody>";
		
		$linha = false; 
		foreach ($dados as $dado){
        	$linha = !$linha;
            $linha?$linhaCor="corSim":$linhaCor="corNao";
    	
    		$table .= '<tr class="'.$linhaCor.'">'; 
        	foreach ($campos as $key => $value){     			
					is_array($value) && isset($value["type"]) ? $type = $value["type"] : $type = null;
					if(is_array($value) && isset($value["field"])){
    					$model = $this->model($value["field"]);
        				$field = $this->field($value["field"]);
        			}
        			isset($value["text"]) ? $text = $value["text"] : $text = $this->format($dado[$model][$field],$type);         			
         			if(is_array($value) && isset($value["link"])){
        				$table .='<td>'.$this->Html->link($text,$this->url($value["link"],$dado),array("class"=>$text))."</td>";
        			}
        			else{
        				$table .= '<td>'.$this->format($dado[$model][$field],$type).'</td>';
        			}
        	}

        }
								
		$table .= "</table>";
		return $table;
	}
			
	function paginacao($paginator){		
		$pg = '<div id="paginas">';
		$pg .= $paginator->prev('Anterior') ." ". $paginator->numbers()." ".$paginator->next('Próxima');
		$pg .='</div>';
		return $pg;
	}
	
	function model($key){
		if(!strpos($key,'.') == false){
    		$m = split('\.',$key);
    	}
		return $m[0];
	}
	
	function field($key){
		if(!strpos($key,'.') == false){
    		$f = split('\.',$key);
    	}
		return $f[1];
	}
	
	function format($field,$type){
		if(is_null($type)){
			return $field;
		}
		if($type == "currency"){
			$fieldVal = $this->Number->currency($field,"BRL");
		}
		if($type == "data"){
			isset($value["format"]) ? $format = $value["format"] : $format = "d/m/Y";
			$fieldVal = $this->Time->format($format,$field);
		}
		return $fieldVal;
	}
	
	function url($link,$dado){
		$url = substr($link,0,strrpos($link,"/")+1);
		$params = substr($link,strrpos($link,"/")+1);
		if(empty($params)){
			return $url;
		}
    	return $url.$dado[$this->model($params)][$this->field($params)];
	}
	
	function busca($options = array()){
		$url = "";
		$label = "";
		isset($this->params["url"]["q"]) ? $q = $this->params["url"]["q"] : $q="";
		if(array_key_exists("url",$options)){ $url = $options['url'];}
		if(array_key_exists("label",$options)){ $label = $options['label'];}
		$busca = "<div id='busca'>".$this->Form->create(null, array('type' => 'get','url' => $url)).
		$this->Form->input("q",array('label'=>$label,'id'=>'keyword',"value"=>$q)).
		$this->Form->end('pesquisar')."</div>";
		
		return $busca;
	}
}
?>