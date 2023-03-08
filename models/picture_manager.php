<?php
	require_once("connect.php");//Classe mère des managers
	/**
	* Class manager de picture
	* @author Timothée KERN
	*/
	class PictureManager extends Manager{
		/**
		* Constructeur de la classe
		*/
		public function __construct(){
			parent::__construct();
		}
		
		/**
		* Méthode de récupération des images
		* @return array Liste des images
		*/
		public function findPicture(){
			$strRqPicture = "SELECT pic_id, pic_name, pic_date, pic_description, pic_userid FROM picture ;";
							
			return $this->_db->query($strRqPicture)->fetchAll();
		}

		/**
		* Méthode d'ajout d'image dans la BDD
		* @param $objPicture objet de l'image à ajouter dans la BDD
		*/
		public function addPicture($objPicture){
           
			//Préparer la requête
			$strRqAdd 	= "	INSERT INTO picture
								(pic_name, pic_date, pic_description, pic_userid)
							VALUES (:name, NOW(), :description, :userid)";			
			$prep		= $this->_db->prepare($strRqAdd);

			//Associer des valeurs aux place holders
			$prep->bindValue(':name', $objPicture->getName(), PDO::PARAM_STR);
			$prep->bindValue(':description', $objPicture->getDescription(), PDO::PARAM_STR);
			$prep->bindValue(':userid', $objPicture->getUserid(), PDO::PARAM_INT);
		
			return $prep->execute();				
		
		}

		/**
		* Méthode de récupération des images de l'utilisateur
		* @return array récupère les images de l'utilisateur
		*/
		public function getPicture(){
			$intId 		= $_GET['id']??$_SESSION['user']['id'];
			$strRqPicture	= "SELECT pic_name, pic_date, pic_description 								  
							FROM picture
								INNER JOIN users ON pic_userid = user_id
							WHERE user_id = '".$intId."'";
							
			$arrPicture	= $this->_db->query($strRqPicture)->fetchAll();
			
			return $arrPicture;
		}

		/**
		* Méthode de récupération du nombre d'images de l'utilisateur
		* @param $intId int id de l'utilisateur 
		* @return bool retourne vrai si trouve au moins 20 images pour l'utilisateur
		*/
		public function verifLimitImg(int $intId):bool{
			$strRq		 	= "SELECT count(pic_id) AS nb								  
							FROM picture
							WHERE pic_userid = ".$intId;
							
			$intCountImg = $this->_db->query($strRq)->fetch();

			if ($intCountImg['nb'] < 20) {
				return false;
			}else {
				return true;
			}
		}
		
	}