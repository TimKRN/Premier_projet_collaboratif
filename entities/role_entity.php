<?php
	/**
	* Class d'une entité propose
	* @author Jérémy Gallippi
	*/
	class Role {
		/* Attributs */
		private $_id;
        private $_name;
	
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
				$strMethod = "set".ucfirst(str_replace("role_", "", $key));
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
		* Getter du nom
		* @return string Name
		*/
		public function getName():string{
			return $this->_name;
		}

		/**
		* Setter du nom
		* @param $strName nom
		*/
		public function setName(string $strName){
			$this->_name = $strName;
		}
    }

?>