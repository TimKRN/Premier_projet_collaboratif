<?php
	/**
	* Controller des erreurs
	* @author Timothée KERN
	*/
	class Error_controller extends Base_controller{
		
		public function error_404(){
			//Affichage
			$this->_arrData['strTitle']	= "Page non trouvée";
			$this->_arrData['strPage']	= "error_404";
			$this->display("error_404");
		}
		
		public function error_403(){
			//Affichage
			$this->_arrData['strTitle']	= "Accès interdit";
			$this->_arrData['strPage']	= "error_403";
			$this->display("error_403");
		}
		
		public function error_error_form_already_completed(){
			//Affichage
			$this->_arrData['strTitle']	= "Formulaire déjà complété";
			$this->_arrData['strPage']	= "error_form_already_completed";
			$this->display("error_form_already_completed");
		}

		public function error_form_limit_img(){
			//Affichage
			$this->_arrData['strTitle']	= "Limite d'images atteinte";
			$this->_arrData['strPage']	= "error_form_limit_img";
			$this->display("error_form_limit_img");
		}
	}