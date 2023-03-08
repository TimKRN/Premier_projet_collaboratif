<?php
	/**
	* Class d'une entité historic
	* @author Timothée KERN 
	*/
	class Historic {
		/* Attributs */
		private $_id;
		private $_new_modif;
		private $_old_modif;
		private $_user;
		private $_date_hour;
		private $_table;
		private $_champ_id;
		private $_champ;
		
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
				$strMethod = "set".ucfirst(str_replace("his_", "", $key));
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
		* Getter de la nouvelle modif
		* @return string Nouvelle Modif
		*/
		public function getNewModif():string{
			return $this->_new_modif;
		}
		/**
		* Setter de la nouvelle modif
		* @param $strNewModif Nouvelle Modif
		*/
		public function setNewModif(string $strNewModif){
			$this->_new_modif = $strNewModif;
		}
		//___________________________________________________________________________
		/**
		* Getter de l'ancienne modif
		* @return string Ancienne Modif
		*/
		public function getOldModif():string{
			return $this->_old_modif;
		}
		/**
		* Setter de l'ancienne modif
		* @param $strOldModif Ancienne Modif
		*/
		public function setOldModif(string $strOldModif){
			$this->_old_modif = $strOldModif;
		}	
		//___________________________________________________________________________
		/**
		* Getter de l'utilisateur
		* @return string Utilisateur
		*/
		public function getUser():string{
			return $this->_user;
		}
		/**
		* Setter de l'utilisateur
		* @param $strUser Utilisateur
		*/
		public function setUser($strUser){
			$this->_user = $strUser;
		}
		//___________________________________________________________________________
		/**
		* Getter de la date et heure
		* @return string Date au format "Thu, 21 Dec 2000 16:01:070200"
		*/
		public function getDateHour():string{
			$dateHour = new DateTime($this->_date_hour);
			return $dateHour->format('r');
		}
		/**
		* Setter de la date et heure
		* @param $dateHour Date et Heure
		*/
		public function setDateHour(string $dateHour){
			$this->_date_hour = $dateHour;
		}
		//___________________________________________________________________________
		/**
		* Getter de la table
		* @return string Table
		*/
		public function getTable():string{
			return $this->_table;
		}
		/**
		* Setter de la table
		* @param $strTable Table
		*/
		public function setTable($strTable){
			$this->_table = $strTable;
		}
		//___________________________________________________________________________
		/**
		* Getter du champ_id
		* @return int Id du Champ
		*/
		public function getChampId():int{
			return $this->_champ_id;
		}
		/**
		* Setter du champ_id
		* @param $intChampId Id Sitter
		*/
		public function setChampId(int $intChampId){
			$this->_champ_id = $intChampId;
		}	
		//___________________________________________________________________________
		/**
		* Getter du champ
		* @return string Champ
		*/
		public function getChamp():string{
			return $this->_champ;
		}
		/**
		* Setter du champ
		* @param $strChamp Champ
		*/
		public function setChamp($strChamp){
			$this->_champ = $strChamp;
		}	
					
		
	}