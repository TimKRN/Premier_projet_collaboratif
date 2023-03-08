<?php
	/**
	* Class d'une entité sitter
	* @author Timothée KERN 
	*/
	class Sitter {
		/* Attributs */
		private $_id;
		private $_type;
		
		/**
		* Constructeur de la classe
		*/
		public function __construct(){
		}
		
		/**
		* Remplissage de l'objet avec les données du tableau
		*/
		public function hydrate($arrData){
			foreach($arrData as $key=>$value){
				$strMethod = "set".ucfirst(str_replace("sitter_", "", $key));
				if (method_exists($this, $strMethod)){
					$this->$strMethod($value);
				}
			}
		}
		
		/* Getters et Setters */
		
		/**
		* Getter de l'id
		* @return int Identifiant
		*/
		public function getId():int{
			return $this->_id;
		}
		/**
		* Setter de l'id
		* @param $intId Identifiant
		*/
		public function setId(int $intId){
			$this->_id = $intId;
		}
		//___________________________________________________________________________
		/**
		* Getter du type
		* @return string Type
		*/
		public function getType():string|null{
			return $this->_type;
		}
		/**
		* Setter du type
		* @param $strType Type
		*/
		public function setType(string $strType){
			$this->_type= $strType;
		}		
	}