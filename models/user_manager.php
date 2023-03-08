<?php
	require_once("connect.php");//Classe mère des managers
	/**
	* Class manager des users
	*/
	class UserManager extends Manager{
		/**
		* Constructeur de la classe
		*/
		public function __construct(){
			parent::__construct();
		}
		
		/**
		* @author Jérémy Gallippi
		* Méthode de récupération des utilisateurs
		* @return array Liste des utilisateurs
		*/

		public function findUser(){
			$strRqSitter = "SELECT user_id, user_name, user_firstname, user_homeid, user_roleid FROM users
				 ;";
							
			return $this->_db->query($strRqSitter)->fetchAll();
		}

		/**
		* @author Jérémy Gallippi
		* Méthode permettant de vérifier un utilisateur pour la connection 
		* @param string $strMail Email de l'utilisateur
		* @param string $strPwd Mot de passe de l'utilisateur
		* @return array|bool Le tableau de l'utilisateur ou false si non trouvé
		*/
		public function verifUser(string $strMail, string $strPassword):array|bool{
			$strRqUsers = "SELECT user_id AS 'id', 
								  user_mail AS 'mail', 
								  user_firstname AS 'firstname',
								  user_roleid AS 'role',
								  user_password 
							FROM users
							WHERE user_mail = '".$strMail."'";
			$arrUser 	= $this->_db->query($strRqUsers)->fetch();

			if ($arrUser !== false){
				//if ($arrUser['user_password'] == $strPassword){ 
				if(password_verify($strPassword, $arrUser['user_password'])) {
					unset($arrUser['user_password']);
                    return $arrUser;
                }
            }
            return false;

        }
     
		
		/**
		* @author Jérémy Gallippi
		* Méthode permettant d'ajouter un utilisateur dans la BDD
		* @param object $objUser Utilisateur à ajouter
		*/
		public function addUsers(object $objUser){           
			// Insertion en BDD, si pas d'erreurs
			$strRqAdd 	= "	INSERT INTO users
								(user_name, user_firstname, user_birthday, user_mail, user_password, user_address, user_phone, user_description, user_cityid, user_roleid, user_homeid)
							VALUES (:name, :firstname, :birthday, :mail, :password, :address, :phone, :description, :cityid, :roleid, :homeid   )";
							
							
			/*('".$objUser->getName()."','".$objUser->getFirstName()."','".$objUser->getBirthday()."','".$objUser->getMail()."','".$objUser->getPassword()."','".$objUser->getAddress()."','".$objUser->getPhone()."', '".$objUser->getDescription()."', '".$objUser->getCityId()."', '2', '5' )*/	
			//return $this->_db->exec($strRqAdd);
			// Requête préparée	
			
			$prep		= $this->_db->prepare($strRqAdd);

			$prep->bindValue(':name', $objUser->getName(), PDO::PARAM_STR);
			$prep->bindValue(':mail', $objUser->getMail(), PDO::PARAM_STR);
			$prep->bindValue(':firstname', $objUser->getFirstName(), PDO::PARAM_STR);
			$prep->bindValue(':password', $objUser->getPassword(), PDO::PARAM_STR);
			$prep->bindValue(':birthday', $objUser->getBirthday(), PDO::PARAM_STR);
			$prep->bindValue(':address', $objUser->getAddress(), PDO::PARAM_STR);
			$prep->bindValue(':cityid', $objUser->getCityId(), PDO::PARAM_INT);
			$prep->bindValue(':phone', $objUser->getPhone(), PDO::PARAM_STR);
			$prep->bindValue(':description', $objUser->getDescription(), PDO::PARAM_STR);
			$prep->bindValue(':roleid', $objUser->getRoleId(), PDO::PARAM_INT);
			$prep->bindValue(':homeid', $objUser->getHomeId(), PDO::PARAM_INT);
		
			return $prep->execute();				
		
		}

		/**
		* @author Jérémy Gallippi
		* Méthode permettant de mettre à jour un utilisateur dans la BDD
		* @param object $objUser Utilisateur à modifier
		* @return bool utilisateur modifié ou non
		*/
		public function updateUser($objUser):bool{
			$strRqUpdate	= "UPDATE users 
								SET user_name = :name, 
									user_firstname = :firstname, 
									user_mail = :mail,
									user_birthday = :birthday,
									user_address  = :address,
									user_cityid   = :cityid,
									user_phone    = :phone,
									user_description = :description,
									user_roleid   = :roleid,
									user_homeid   = :homeid";
									if ($objUser->getPassword() != ''){
										$strRqUpdate	.=	", user_password = :password";
									}

			if ($objUser->getPassword() != ''){
				$strRqUpdate	.=	", user_password = :password";
			}
			$strRqUpdate	.= " WHERE user_id = ".$objUser->getId();//$_SESSION['user']['id'];
			$prep			= $this->_db->prepare($strRqUpdate);
			
			$prep->bindValue(':name', $objUser->getName(), PDO::PARAM_STR);
			$prep->bindValue(':mail', $objUser->getMail(), PDO::PARAM_STR);
			$prep->bindValue(':firstname', $objUser->getFirstName(), PDO::PARAM_STR);
			if ($objUser->getPassword() != ''){
				$prep->bindValue(':password', $objUser->getPassword(), PDO::PARAM_STR);
			}
			$prep->bindValue(':birthday', $objUser->getBirthday(), PDO::PARAM_STR);
			$prep->bindValue(':address', $objUser->getAddress(), PDO::PARAM_STR);
			$prep->bindValue(':cityid', $objUser->getCityId(), PDO::PARAM_INT);
			$prep->bindValue(':phone', $objUser->getPhone(), PDO::PARAM_STR);
			$prep->bindValue(':description', $objUser->getDescription(), PDO::PARAM_STR);
			$prep->bindValue(':roleid', $objUser->getRoleId(), PDO::PARAM_INT);
			$prep->bindValue(':homeid', $objUser->getHomeId(), PDO::PARAM_INT);
			//var_dump($prep->execute());die;
			return $prep->execute();
		}
		
		/**
		* @author Jérémy Gallippi
		* Méthode permettant de récupérer un utilisateur
		* @return array|bool L'utilisateur courant ou false si non trouvé
		*/
		public function getUser():array|bool{
			$intId 		= $_GET['id']??$_SESSION['user']['id'];
			$strRqUser 	= "SELECT user_id AS 'id', 
								  user_firstname AS 'firstname', 
								  user_name AS 'name', 
								  user_mail AS 'mail',
								  user_address AS 'address',
								  user_phone AS 'phone',
								  user_homeid AS 'homeid',
								  user_description AS 'description',
								  user_cityid AS 'cityid',
								  user_roleid,
								  user_birthday AS 'birthday'
								  
							FROM users
							WHERE user_id = '".$intId."'";
							
			$arrUser 	= $this->_db->query($strRqUser)->fetch();
			
			return $arrUser;
		}


		

		/**
		* @author Timothée KERN
        * Méthode de modifier le type d'habitation pour l'utilisateur        
        * @param $objUser objet de l'utilisateur à modifier dans la BDD
		* @param $intId int Id de l'utilisateur
        */
        public function editHome(object $objUser, int $intId){

            // Insertion en BDD, si pas d'erreurs
            $strRqAddPetsitter     = "UPDATE users
                                SET user_homeid = :homeid
                                WHERE user_id = $intId";

            // Requête préparée
            $prep        = $this->_db->prepare($strRqAddPetsitter);

            $prep->bindValue(':homeid', $objUser->getHomeId(), PDO::PARAM_INT);

            return $prep->execute();

        }
		
		/**
		* @author Jérémy Gallippi
		* Méthode permettant de vérifier que le mail n'existe pas déjà en BDD
		* @param object $objUser Objet de l'utilisateur
		* @return bool le mail existe ou non
		*/
		public function mail_exist(object $objUser):bool{
			$strRqUsers = "SELECT *
							FROM users
							WHERE user_mail = :mail";
			if ($objUser->getId() != ''){
				$strRqUsers	.=	" AND user_id <> :id";
			}							
			$prep	= $this->_db->prepare($strRqUsers);
			
			$prep->bindValue(':mail', $objUser->getMail(), PDO::PARAM_STR);	
			if ($objUser->getId() != ''){
				$prep->bindValue(':id', $objUser->getId(), PDO::PARAM_INT);	
			}

			$prep->execute();
			$arrUser = $prep->fetch();
			
			return ($arrUser !== false);
		}

		/**
		* @author Jérémy Gallippi
		* Méthode permettant de supprimer un utilisateur
		*/
		public function deleteUser()
		{
			$intId = $_GET['id']??$_SESSION['user']['id'];
			$strDelUserQuery = "DELETE FROM users WHERE user_id = $intId";
			return $this->_db->exec($strDelUserQuery);
		}

		/**
		* @author Jérémy Gallippi
		* Méthode permettant de récupérer le role d' un utilisateur
		* @param int $intId Id de l'utilisateur
		*/
		public function findRole(int $intId){
			$strRqRole ="SELECT user_roleid AS role_id, role_name FROM users 
							INNER JOIN role ON user_roleid = role_id
							 WHERE user_id = $intId";
			return $this->_db->query($strRqRole)->fetchAll();
		}		
		
	}