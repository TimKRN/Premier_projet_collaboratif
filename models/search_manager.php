<?php
	require_once("connect.php");//Classe mère des managers
	/**
	* Class manager de la recherche
	* @author Timothée KERN 
	*/
	class SearchManager extends Manager{
		/**
		* Constructeur de la classe
		*/
		public function __construct(){
			parent::__construct();
		}
		
		/**
		* Méthode de récupération des petsitters
		* @return array Liste des résultats en fonction des filtres (type d'animal, type de garde et code postal) appliqués
		*/
		public function findPetSitter(){
			
				// Début de la requête
			$strRq 		= "	SELECT user_id, city_name, user_firstname, user_birthday, home_type
							FROM users
								INNER JOIN home ON user_homeid = home_id
								INNER JOIN city ON user_cityid = city_id 
									WHERE user_id IN (SELECT prop_userid FROM propose ";
			$strWhere	= " WHERE ";
			
			
			// Traitement du type d'animal
			$intAnimal = $_POST['animal']??'';
			if ($intAnimal != ''){
				$intAnimal	= implode(",", $_POST['animal'])??'';
				$strRq 		.= $strWhere." prop_pet_typeid IN ( ".$intAnimal.")";
			}

			// Traitement du type de garde
			$intSitter = $_POST['garde']??'';
			if ($intSitter != ''){
				if ($intAnimal != '') {
					$strWhere	= " AND ";
				}				
				$intSitter	= implode(",", $_POST['garde'])??'';
				$strRq 		.= $strWhere." prop_sitterid IN ( ".$intSitter.")";
			}

			// Traitement du code postal
			$intCP 	= $_POST['cp']??'';
			if ($intCP != ''){
				$strWhere = ") AND ";
				$strRq 		.= $strWhere." city_cp = ".$intCP;
			}

			// Classement des résultats
			
			if ($intAnimal == '' && $intSitter == '' && $intCP == '') {
				$strRq 		.= ")";
			}
			elseif ($intCP == ''){
				$strRq 		.= ")";
			}
			$strRq 		.= " AND user_id IN (SELECT prop_userid FROM propose WHERE prop_valid =1)"; //Uniquement les résultats validés par un modérateur au préalable
			$strRq 		.= " ORDER BY city_cp";
			
			
			//Variable Selection de la table dans la base de données 
			return $this->_db->query($strRq)->fetchAll();
			
		}
		
	}