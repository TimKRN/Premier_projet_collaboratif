<?php
	/**
	* Class d'une entité picture
	* @author Timothée KERN 
	*/
	class Picture {
		/* Attributs */
		private $_id;
		private $_name;
		private $_date;
		private $_description;
		private $_userid;
		
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
				$strMethod = "set".ucfirst(str_replace("pic_", "", $key));
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
		* Getter du nom
		* @return string Nom
		*/
		public function getName():string|null{
			return $this->_name;
		}
		/**
		* Setter du nom
		* @param $strTitle Nom
		*/
		public function setName(string $strName){
			$this->_name= $strName;
		}
		//___________________________________________________________________________
		/**
		* Getter de la date 
		* @return string Date au format d/m/Y
		*/
		public function getDate():string{
			$date = new DateTime($this->_date);
			return $date->format('d/m/Y');
		}
		/**
		* Setter de la date
		* @param $datz Date 
		*/
		public function setDate(string $date){
			$this->_date = $date;
		}		
		//___________________________________________________________________________
		/**
		* Getter de la description
		* @return string Description
		*/
		public function getDescription():string|null{
			return $this->_description;
		}
		/**
		* Setter de la description
		* @param $strDescription Description
		*/
		public function setDescription($strDescription){
			$this->_description = $strDescription;
		}
		//___________________________________________________________________________
		/**
		* Getter du userid
		* @return int Id Userid
		*/
		public function getUserid():int{
			return $this->_userid;
		}
		/**
		* Setter du userid
		* @param $intUserid Id Userid
		*/
		public function setUserid(int $intUserid){
			$this->_userid = $intUserid;
		}
		
	}