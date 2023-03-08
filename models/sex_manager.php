<?php
	require_once("connect.php");//Classe mère des managers
	/**
	* Class manager de sex
	* @author Timothée KERN
	*/
	class SexManager extends Manager{
		/**
		* Constructeur de la classe
		*/
		public function __construct(){
			parent::__construct();
		}
		
		/**
		* Méthode de récupération de la liste des sexes
		* @return array Liste des sexes
		*/
		public function findSex(){
			$strRqSex = "SELECT sex_id, sex_type FROM sex ;";
							
			return $this->_db->query($strRqSex)->fetchAll();
		}

		/**
		* Méthode de récupération du sexe de l'animal de l'utilisateur
		* @param int $intPetId Id de l'animal 
		* @return string $strSex le sexe de l'animal de l'utilisateur
		*/
		public function getSex($intPetId){
			$strRqSex	= "SELECT sex_type								  
							FROM sex
								INNER JOIN pet ON pet_sexid = sex_id
							WHERE pet_id = '".$intPetId."'";
							
			$strSex 	= $this->_db->query($strRqSex)->fetch();
			
			return $strSex;
		}
		
	}