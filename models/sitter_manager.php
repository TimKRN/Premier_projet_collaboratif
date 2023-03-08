<?php
	require_once("connect.php");//Classe mère des managers
	/**
	* Class manager de sitter
	* @author Timothée KERN
	*/
	class SitterManager extends Manager{
		/**
		* Constructeur de la classe
		*/
		public function __construct(){
			parent::__construct();
		}
		
		/**
		* Méthode de récupération des types d'animaux
		* @return array Liste des types d'animaux
		*/
		public function findSitter(){
			$strRqSitter = "SELECT sitter_id, sitter_type FROM sitter ;";
							
			return $this->_db->query($strRqSitter)->fetchAll();
		}

		/**
		* Méthode de récupération du type de garde 
		* @param $intProposeId int Id de la proposition de garde
		* @return string récupère le type de garde proposé par l'utilisateur 
		*/
		public function getSitter($intProposeId){
			$strRqSitter	= "SELECT sitter_type 								  
							FROM sitter
								INNER JOIN propose ON prop_sitterid = sitter_id
							WHERE prop_id = '".$intProposeId."'";
							
			$strSitter 	= $this->_db->query($strRqSitter)->fetch();
			
			return $strSitter;
		}
		
	}