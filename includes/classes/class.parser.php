<?php
class TemplateParser {
	private $templatecontent;
	private $blockcontent = Array();
  
  	public function loadfile($file) {
     	$this->templatefile = $file;
     	$this->templatecontent = file_get_contents($this->templatefile);
  	}
	
  	public function assignvars($vars, $values) {
     	$this->templatecontent = str_replace($vars, $values, $this->templatecontent);
  	}
	
	public function assignblock($block, $html) {
		$this->templatecontent = str_replace($block, $html, $this->templatecontent);
	} 
	
  	public function output() {
     	return $this->templatecontent;
  	}
}
?>
