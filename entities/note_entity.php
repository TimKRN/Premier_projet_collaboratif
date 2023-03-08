<?php
	/**
	* Class d'une entité note
	* @author Timothée KERN 
	*/
	class Note {
		/* Attributs */
		private $_id;
		private $_val;
		private $_comment;
		private $_clientid;
		private $_petsitterid;
		private $_sitterid;
		
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
				$strMethod = "set".ucfirst(str_replace("note_", "", $key));
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
		* Getter de la valeur
		* @return int Valeur
		*/
		public function getVal():int{
			return $this->_val;
		}
		/**
		* Setter de la valeur
		* @param $intVal Valeur
		*/
		public function setVal(int $intVal){
			$this->_val = $intVal;
		}	
		//___________________________________________________________________________
		/**
		* Getter du commentaire
		* @return string Commentaire
		*/
		public function getComment():string{
			return $this->_comment;
		}
		/**
		* Setter du commentaire
		* @param $strComment Commentaire
		*/
		public function setComment($strComment){
			$this->_comment = $strComment;
		}
		//___________________________________________________________________________
		/**
		* Getter du clientid
		* @return int Id Client
		*/
		public function getClientid():int{
			return $this->_clientid;
		}
		/**
		* Setter du clientid
		* @param $intClientid Id Client
		*/
		public function setClienid(int $intClientid){
			$this->_clientid = $intClientid;
		}
		//___________________________________________________________________________
		/**
		* Getter du petsitterid
		* @return int Id Petsitter
		*/
		public function getPetSitterid():int{
			return $this->_petsitterid;
		}
		/**
		* Setter du petsitterid
		* @param $intPetsitterid Id Petsitter
		*/
		public function setPetSitterid(int $intPetsitterid){
			$this->_petsitterid = $intPetsitterid;
		}
		//___________________________________________________________________________
		/**
		* Getter du sitterid
		* @return int Id Sitter
		*/
		public function getSitterid():int{
			return $this->_sitterid;
		}
		/**
		* Setter du sitterid
		* @param $intSitterid Id Sitter
		*/
		public function setSitterid(int $intSitterid){
			$this->_sitterid = $intSitterid;
		}
		
	}