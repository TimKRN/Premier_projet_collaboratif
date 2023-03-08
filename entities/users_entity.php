<?php
	/**
	* Class d'une entité user
	* @author Jérémy Gallippi
	*/
	class User {
		/* Attributs */
		private $_id;
		private $_name;
		private $_firstname;
		private $_birthday;
		private $_mail;
		private $_password;
        private $_address;
        private $_phone;
        private $_description;
        private $_iban;
        private $_homeid=5;
        private $_cityid;
        private $_roleid=2;

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
				$strMethod = "set".ucfirst(str_replace("user_", "", $key));
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
		public function setId(int|string $intId){
			$this->_id = intval($intId);
		}

		/**
		* Getter du nom
		* @return string Name
		*/
		public function getName():string|null{
			return $this->_name;
		}
		/**
		* Setter du nom
		* @param $strName nom
		*/
		public function setName(string $strName){
			$this->_name = filter_var(trim($strName),FILTER_SANITIZE_SPECIAL_CHARS);
		}
		
		/**
		* Getter du nom de famille
		* @return string Nom de famille
		*/

		public function getFirstName():string|null{


			return $this->_firstname;
		}
		/**
		* Setter du nom de famille
		* @param $strLastName Nom de l'image
		*/
		public function setFirstName(string $strFirstName){


			$this->_firstname = $strFirstName;

		}
		
		/**
		* Getter de l'anniversaire
		* @return string Birthday
		*/
		public function getBirthday():string|null{
            return $this->_birthday;
			/*$date = new DateTime($this->_birthday);
			return $date->format('Y-m-d');*/
		}
		/**
		* Setter de l'anniversaire
		* @param $strBirthday Birthday
		*/
		public function setBirthday(string $strBirthday){
			$this->_birthday = filter_var(trim($strBirthday),FILTER_SANITIZE_SPECIAL_CHARS);
		}

		/**
		* Getter du mail
		* @return string mail
		*/
		public function getMail():string|null{
			return $this->_mail;
		}
		/**
		* Setter du mail
		* @param $strMail Mail
		*/
		public function setMail($strMail){
			$this->_mail = filter_var(trim(strtolower($strMail)),FILTER_SANITIZE_SPECIAL_CHARS);
		}

        /**
		* Getter du mot de passe
		* @return string Password
		*/
		public function getPassword():string{
			return $this->_password;
		}
		/**
		* Setter du mot de passe
		* @param $strPassword mot de passe
		*/
		public function setPassword($strPassword){
			$strPassword = filter_var(trim($strPassword),FILTER_SANITIZE_SPECIAL_CHARS);
			if ($strPassword != ''){ // On ne hache le mot de passe que s'il est renseigné
				$this->_password = password_hash($strPassword, PASSWORD_DEFAULT);
			}else{
				$this->_password = $strPassword;
			}
		}
		
        /**
		* Getter de l'adresse
		* @return string adress
		*/
		public function getAddress():string|null{
			return $this->_address;
		}
		/**
		* Setter de l'adresse
		* @param $strAdress Adress
		*/
		public function setAddress($strAddress){
			$this->_address = filter_var(trim($strAddress),FILTER_SANITIZE_SPECIAL_CHARS);
		}
		
        /**
		* Getter du numéro de téléphone
		* @return string Phone
		*/
		public function getPhone():string|null{
			return $this->_phone;
		}
		/**
		* Setter du numéro de téléphone
		* @param $strPhone Phone
		*/
		public function setPhone($strPhone){
			$this->_phone = filter_var(trim($strPhone),FILTER_SANITIZE_SPECIAL_CHARS);
		}
		
        /**
		* Getter de la description
		* @return string Drescription
		*/
		public function getDescription():string|null{
			return $this->_description;
		}
		/**
		* Setter de la description
		* @param $strDescription Description
		*/
		public function setDescription($strDescription){
			$this->_description = filter_var(trim($strDescription),FILTER_SANITIZE_SPECIAL_CHARS);
		}
		
        /**
		* Getter de l'Iban
		* @return string Iban
		*/
		public function getIban():string{
			return $this->_iban;
		}
		/**
		* Setter de l'Iban
		* @param $strIban Iban
		*/
		public function setIban($strIban){
			$this->_iban= $strIban;
		}
		
		/*Clé ETRANGERE!*/

        /**
		* Getter du homeid
        * @return int Id Homeid
        */
        public function getHomeId():int{
            return $this->_homeid;
        }
        /**
        * Setter du homeid
        * @param $intHomeId
        */
        public function setHomeId(int $intHomeId){
            $this->_homeid = $intHomeId;
        }

        /**
		*  Getter du cityid
        * @return int CityId
        */
        public function getCityId():int{
            return $this->_cityid;
        }
        /**
        * Setter du cityid
        * @param $intCityId
        */
        public function setCityId(int|string $intCityId){
            $this->_cityid = intval($intCityId);
        }

        /**
		*  Getter du roleid
        * @return int RoleId
        */
        public function getRoleId():int{
            return $this->_roleid;
        }
        /**
        * Setter du roleid
        * @param $intRoleId
        */
        public function setRoleId(int $intRoleId){
            $this->_roleid = $intRoleId;
        }
	}