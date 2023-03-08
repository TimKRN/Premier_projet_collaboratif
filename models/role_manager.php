<?php
	require_once("connect.php");//Classe mère des managers
	/**
	* Class manager de role
	* @author Jérémy Gallippi
	*/
	class RoleManager extends Manager{
		/**
		* Constructeur de la classe
		*/
		public function __construct(){
			parent::__construct();
		}
		
		/**
		* Méthode de récupération des roles
		* @return array Liste des roles
		*/
		public function getRoleId(){
			$strRqRole = "SELECT role_id, role_name FROM role ;";
							
			return $this->_db->query($strRqRole)->fetchAll();
		}

		/**
		* Méthode de récupération du rôle de l'utilisateur
		* @return string récupère le rôle de l'utilisateur
		*/
		public function getRole(){
			$intId 		= $_GET['id']??$_SESSION['user']['id'];
			$strRqRole	= "SELECT role_name								  
							FROM role
								INNER JOIN users ON user_roleid = role_id
							WHERE user_id = '".$intId."'";
							
			$strRole 	= $this->_db->query($strRqRole)->fetch();
			
			return $strRole;
		}
		
	}