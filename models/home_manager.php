<?php
	require_once("connect.php");//Classe mère des managers
	/**
	* Class manager de home
	* @author Timothée KERN
	*/
	class HomeManager extends Manager{
		/**
		* Constructeur de la classe
		*/
		public function __construct(){
			parent::__construct();
		}
		
		/**
		* Méthode de récupération des types de logement
		* @return array Liste des types de logement
		*/
		public function findHome(){
			$strRqHome = "SELECT home_id, home_type FROM home ;";
							
			return $this->_db->query($strRqHome)->fetchAll();
		}

		/**
		* Méthode de récupération du type d'habitation de l'utilisateur 
		* @return string récupère le type d'habitation de l'utilisateur 
		*/
		public function getHome(){
			$intId 		= $_GET['id']??$_SESSION['user']['id'];
			$strRqHome	= "SELECT home_type  								  
							FROM home
								INNER JOIN users ON user_homeid = home_id
							WHERE user_id = '".$intId."'";
							
			$strHome 	= $this->_db->query($strRqHome)->fetch();
			
			return $strHome;
		}
		
	}