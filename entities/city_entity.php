<?php
	/**
	* Class d'une entité city
	* @author Jérémy Gallippi
	*/
	class City {
		/* Attributs */
		private $_id;
        private $_name;
        private $_cp;
	
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
				$strMethod = "set".ucfirst(str_replace("city_", "", $key));
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
        /**
		* Getter du nom de la ville
		* @return string Name
		*/
		public function getName():string{
			return $this->_name;
		}

		/**
		* Setter du nom de la ville
		* @param $strName nom
		*/
		public function setName(string $strName){
			$this->_name = $strName;
		}

        /**
		* Getter du code postal
		* @return string Cp
		*/
		public function getCp():string{
			return $this->_cp;
		}

		/**
		* Setter du code postal
		* @param $strCp 
		*/
		public function setCp(string $strCp){
			$this->_cp = $strCp;
		}
    }

?>