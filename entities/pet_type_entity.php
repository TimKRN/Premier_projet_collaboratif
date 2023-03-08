<?php
	/**
	* Class d'une entité pet_type
	* @author Timothée KERN 
	*/
	class Pet_type {
		/* Attributs */
		private $_id;
		private $_kind;
		
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
				$strMethod = "set".ucfirst(str_replace("pet_type_", "", $key));
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
		public function getKind():string|null{
			return $this->_kind;
		}
		/**
		* Setter du type
		* @param $strKind Type
		*/
		public function setKind(string $strKind){
			$this->_kind= $strKind;
		}		
	}