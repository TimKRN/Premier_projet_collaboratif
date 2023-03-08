<?php
	require_once("connect.php");//Classe mère des managers
	/**
	* Class manager de propose
	* @author Timothée KERN
	*/
	class ProposeManager extends Manager{
		/**
		* Constructeur de la classe
		*/
		public function __construct(){
			parent::__construct();
		}
		
		/**
		* Méthode de récupération des petsitters à valider
		* @return array Liste des petsitters pour la vue modérateur
		*/
		public function findPetsitter(){
			$strRqSitter = "SELECT DISTINCT user_id, user_name, user_firstname FROM users
								INNER JOIN propose ON prop_userid = user_id
							WHERE prop_valid = 0";
							
			return $this->_db->query($strRqSitter)->fetchAll();
		}
		
		/**
		* Méthode de récupération des infos du Petsitter connecté
		* @param $intId int id de l'utilisateur 
		* @return bool retourne vrai si trouve un petsitter avec l'id renseigné dans la BDD
		*/
		public function getPetsitter(int $intId):bool{
			$strRqPetsitter 	= "SELECT * 								  
							FROM propose
							WHERE prop_userid = ".$intId;
							
			$arrPetsitter = $this->_db->query($strRqPetsitter)->fetch();
			
			return ($arrPetsitter !== false);
		}
		
		/**
		* Méthode de création d'un petsitter
		* @param $objPetsitter objet du Petsitter à ajouter dans la base de données
		* @param $intId int Id de l'utilisateur connecté
		*/		
		public function addPetsitter(object $objPetsitter, int $intId){

           
			// Insertion en BDD, si pas d'erreurs
			$strRqAddPetsitter 	= "	INSERT INTO propose
								(prop_userid, prop_sitterid, prop_pet_typeid)
							VALUES ($intId, :sitterid, :pet_typeid)";
							
			// Requête préparée	
			$prep		= $this->_db->prepare($strRqAddPetsitter);

			$prep->bindValue(':sitterid', $objPetsitter->getSitterId(), PDO::PARAM_INT);
			$prep->bindValue(':pet_typeid', $objPetsitter->getPetTypeId(), PDO::PARAM_INT);
		
			return $prep->execute();				
		
		}

		/**
		* Méthode de suppression d'un petsitter
		*/
		public function deletePetsitter()
		{
			$intId = $_GET['id']??$_SESSION['user']['id'];
			$strDelPetSitter = "DELETE FROM propose WHERE prop_userid = $intId";
			return $this->_db->exec($strDelPetSitter);
		}

		/**
		* Méthode de validation d'une proposition de garde
		* @param $objPetsitter objet du Petsitter dans la BDD
		* proposition validée ou non (passe de 0 à 1 en BDD)
		*/		
		public function updatePetsitter(object $objPetsitter){

			$strRqUpdate 	= "UPDATE propose 
								SET prop_valid = 1
								WHERE prop_id = ".$objPetsitter->getId();		
			return $this->_db->exec($strRqUpdate);				
		
		}

		/**
		* Méthode de récupération des infos du Petsitter
		*/
		public function getPetsitterDisplay(){
			$intId 				= $_GET['id']??$_SESSION['user']['id'];
			$strRqPetsitter 	= "SELECT *							  
							FROM propose
							WHERE prop_userid = ".$intId;
							
			$arrPetsitter 	= $this->_db->query($strRqPetsitter)->fetchAll();

			return $arrPetsitter;
		}

		/**
		* Méthode de récupération des infos de la proposition de garde
		* @param $intPropId int ID de la proposition de garde 
		* @return array $arrPetsitter infos de la proposition de garde 
		*/
		public function getPetsitterForValid($intPropId){
			$strRqPetsitter 	= "SELECT *							  
							FROM propose
							WHERE prop_id = ".$intPropId;
							
			$arrPetsitter 	= $this->_db->query($strRqPetsitter)->fetch();

			return $arrPetsitter;
		}
	}