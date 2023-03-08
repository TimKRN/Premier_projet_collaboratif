<?php
	/**
	* Class d'une entité pet
	* @author Timothée KERN 
	*/
	class Pet {
		/* Attributs */
		private $_id;
		private $_name;
		private $_birthday;
		private $_userid;
		private $_typeid;
		private $_sexid;
		
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
				$strMethod = "set".ucfirst(str_replace("pet_", "", $key));
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
		public function getId():int|null{
			return $this->_id;
		}
		/**
		* Setter de l'id
		* @param $intId Identifiant
		*/
		public function setId(int $intId){
			$this->_id = intval($intId);
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
			$this->_name = filter_var(trim($strName),FILTER_SANITIZE_SPECIAL_CHARS);
		}
		//___________________________________________________________________________
		/**
		* Getter de la date d'anniversaire
		* @return string Date d'anniversaire 
		*/
		public function getBirthday():string|null{
            return $this->_birthday;
		}
		/**
		* Setter de l'anniversaire
		* @param $strBirthday Birthday
		*/
		public function setBirthday(string|null $strBirthday){
			if (($strBirthday)) {
				$this->_birthday = filter_var(trim($strBirthday),FILTER_SANITIZE_SPECIAL_CHARS);
			}
			
		}

		//___________________________________________________________________________
		/**
		* Getter du userid
		* @return int Id Userid
		*/
		public function getUserid():int|null{
			return $this->_userid;
		}
		/**
		* Setter du userid
		* @param $intUserid Id Userid
		*/
		public function setUserid(int|string|null $intUserid){
			$this->_userid = intval($intUserid);
		}
		//___________________________________________________________________________
		/**
		* Getter du typeid
		* @return int Id Type
		*/
		public function getTypeid():int|null{
			return $this->_typeid;
		}
		/**
		* Setter du typeid
		* @param $intTypeid Id Type
		*/
		public function setTypeid(int $intTypeid){
			$this->_typeid = $intTypeid;
		}	
		//___________________________________________________________________________
		/**
		* Getter du sexid
		* @return int Id Sex
		*/
		public function getSexid():int|null{
			return $this->_sexid;
		}
		/**
		* Setter du sexid
		* @param $intSexid Id Sex
		*/
		public function setSexid(int $intSexid){
			$this->_sexid = $intSexid;
		}
				
	}