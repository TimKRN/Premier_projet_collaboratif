<?php
	/**
	* Controller des utilisateurs
	* @author Jérémy GALLIPPI
	* <ul>
	*	<li>Page Se connecter</li>
	*	<li>Page Inscription</li>
	*	<li>Page Se déconnecter</li>
	*	<li>Page modifier le compte</li>
	*	<li>Méthode de suppression d'un utilisateur</li>
	*	<li>Page liste des petsitters soumis à validation pour les modérateurs</li>
	* </ul>
	* @author Timothée KERN
	* <ul>
	*	<li>Page profil</li>
	* 	<li>Méthode de validation d'un sitter</li>
	* </ul>
	*/
	class User_controller extends Base_controller{
		

		/**
		* Constructeur de la classe
		*/ 
		public function __construct(){
			//user
			require("models/user_manager.php"); 
			require("entities/users_entity.php"); 
			//city
			require("models/city_manager.php");
			require("entities/city_entity.php");
			//home
			require("models/home_manager.php"); 
			require("entities/home_entity.php"); 
			//role
			require("entities/role_entity.php"); 
			require("models/role_manager.php"); 
			//pet
			require("models/pet_manager.php"); 
			require("entities/pet_entity.php"); 
			//sitter
			require("models/sitter_manager.php"); 
			require("entities/sitter_entity.php"); 
			//pet_type
			require("models/pet_type_manager.php"); 
			require("entities/pet_type_entity.php");
			//sex
			require("models/sex_manager.php"); 
			require("entities/sex_entity.php");
			//picture
			require("models/picture_manager.php"); 
			require("entities/picture_entity.php");
			//propose
			require("models/propose_manager.php"); 
			require("entities/propose_entity.php");
		}

		/**
		* Page Se connecter
		*/
		public function login(){
			// Vérifier l'utilisateur / mdp en base de données (Attention aux infos vides)
			// Stocker les informations utiles de l'utilisateur en session
			// Exemple : $_SESSION['id'] = 15; ou $_SESSION['user']['id'] = 15;

			if (count($_POST) > 0){
				$strMail 	= $_POST['mail'];
				$strPassword 	= $_POST['password'];
				
				$objUserManager = new UserManager();
				// Vérifier l'utilisateur / mdp en base de données
				$arrUser = $objUserManager->verifUser($strMail, $strPassword);
				if ($arrUser === false){
					$this->_arrData['strError'] = "Erreur de connexion";
				}else{
					// Stocker les informations utiles de l'utilisateur en session
					$_SESSION['user']	= $arrUser;
				}
			}
			header("Location:index.php");			
			

		}

		//_________________________________________________________________________________________________________

		/**
		* Page Inscription
		*/
		
		public function inscription(){

			// Pour récupérer les informations dans le formulaire
			
			$intCityId			=  $_POST['cityid']??'';	
			$boolPersonalData 	=  $_POST['personal_data']??'';

			$arrError 			= array(); // Tableau des erreurs initialisé
			$arrCityToDisplay 	= array();
			$arrSelected		= array();
			$objUserManager 	= new UserManager();
			$objUser 			= new User; //
						
		
			$strConfirmPassword		= $_POST['confirmpassword']??'';

			// Liste des villes
			/*require("entities/city_entity.php"); 
			require("models/city_manager.php"); */
			$objCityManager  = new CityManager(); 
			$arrCity 	    = $objCityManager->findCity(); 
			
			foreach($arrCity as $arrDetCity){
				$objCity = new City;
				$objCity->hydrate($arrDetCity);
				if ($intCityId == $objCity->getId()) {
					$arrSelected[] = $objCity->getId();
				}
				//$objCity->selected = ($intCityId == $objCity->getId())?"selected":"";
				$arrCityToDisplay[] = $objCity;
			}
		
				
			if (count($_POST) > 0) { // Si le formulaire est envoyé
				// On teste les informations
				$objUser->hydrate($_POST);


				if ($objUser->getName() == ''){ // Tests sur le nom
					$arrError[]	= "Merci de renseigner un nom";
				}
				if ($objUser->getFirstName() == ''){ // Tests sur le prénom
					$arrError[]	= "Merci de renseigner un prénom";
				}else if($objUserManager->mail_exist($objUser)){ // test si déjà existant
					$arrError[]	= "Mail déjà utilisé, merci d'en renseigner une autre ou de vous connecter";
				}
				 if($objUser->getMail()== ''){ // test si déjà existant
					$arrError[]	= "Merci de renseigner Mail";
				}
				/*if ($objUser->getMail() == ''){ // Tests sur le mail
					$arrError[]	= "Merci de renseigner une adresse mail";
				}*/
				if ($objUser->getPassword() == ''){ // Tests sur le mot de passe
					$arrError[]	= "Merci de renseigner un mot de passe";
				}
				if (!preg_match("/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/ ", $_POST["password"])){ 
					$arrError[] = "Le mot de passe doit contenir au moins 8 caractères , un caractère spécial et une majuscule/minuscule";
				}
	
				if (!password_verify($_POST['confirmpassword'], $objUser->getPassword())){ // Tests sur la confirmation du mot de passe
					$arrError[]	= "Le mot de passe et sa confirmation ne sont pas identiques";
				}

				if ($objUser->getPhone() == ''){ // Tests sur le nom
					$arrError[]	= "Merci de renseigner un numéro de téléphone";
				}

				if ($objUser->getBirthday() == ''){ // Tests sur le nom
					$arrError[]	= "Merci de renseigner une date de naissance";
				}

				if ($objUser->getAddress() == ''){ // Tests sur le nom
					$arrError[]	= "Merci de renseigner une adresse";
				}

				if ($objUser->getCityId() == ''){ // Tests sur le nom
					$arrError[]	= "Merci de renseigner une ville";
				}
				if ($boolPersonalData == ''){ // Case d'autorisation de traitement des données personnelles
					$arrError[]	= "Merci d'accepter le traitement des données transmises";
				}
				// Si aucune erreur, on créer l'objet User et on l'insert en BDD
				if (count($arrError) == 0){ 
											
					
					$objUserManager = new UserManager;
					if($objUserManager->addUsers($objUser)){
						header("Location:index.php");
					}else{
						$arrError[]	= "Erreur lors de l'ajout";
					}
				}				
			}

			$this->_arrData['arrSelected']			= $arrSelected;
			$this->_arrData['arrCityToDisplay']		= $arrCityToDisplay;
			$this->_arrData['objUser']				= $objUser;
			$this->_arrData['arrError']				= $arrError;
			$this->_arrData['strTitle']				= "PetSitter - Inscription";
			$this->_arrData['strPage']				= "inscription";

			$this->display("inscription");
		}	

		//_________________________________________________________________________________________________________
		
		/**
		* Page Se déconnecter
		*/
		public function logout(){
			session_destroy();

			header("Location:index.php");
		}

		//_________________________________________________________________________________________________________

		/**
		* Page modifier le compte
		*/
		public function edit_account(){
			if (// utilisateur non connecté
				(!isset($_SESSION['user'])) 
			||  
				// utilisateur non admin qui veut changer un autre compte
				(isset($_GET['id']) && $_SESSION['user']['role'] != 1) ){
				header("Location:index.php?ctrl=error&action=error_403");
			}
			// Créer un objet vide avec l'entité 
			// Création de l'objet User
			$intCityId		= $_POST['cityid']??'';	
			$boolPersonalData 	=  $_POST['personal_data']??'';
			$objUserManager = new UserManager;
			$objUser 		= new User;
			$boolPersonalData 	=  $_POST['personal_data']??'';
			$objRoleManager  = new RoleManager();
			$objCityManager  = new CityManager(); 
			$arrCity 	     = $objCityManager->findCity(); 
			
		
					
			$arrError = array(); // Tableau des erreurs initialisé
			if (count($_POST) > 0) { // Si le formulaire est envoyé
				// On hydrate l'objet
				$objUser->hydrate($_POST);
				// On teste les informations
				if ($objUser->getName() == ''){ // Tests sur le nom
					$arrError[]	= "Merci de renseigner un nom";
				}
				if ($objUser->getFirstName() == ''){ // Tests sur le prénom
					$arrError[]	= "Merci de renseigner un prénom";
				}else if($objUserManager->mail_exist($objUser)){ // test si déjà existant
					$arrError[]	= "Mail déjà utilisé, merci d'en renseigner une autre ou de vous connecter";
				}
				 if($objUser->getMail()== ''){ // test si déjà existant
					$arrError[]	= "Merci de renseigner Mail";
				}


				if ($objUser->getPassword() != '' && !password_verify($_POST['confirmpassword'], $objUser->getPassword())){ // Tests sur la confirmation du mot de passe
                    $arrError[]    = "Le mot de passe et sa confirmation ne sont pas identiques";
                }
				/*if ($objUser->getMail() == ''){ // Tests sur le mail
					$arrError[]	= "Merci de renseigner une adresse mail";
				}*/
				/*if ($objUser->getPassword() == ''){ // Tests sur le mot de passe
					$arrError[]	= "Merci de renseigner un mot de passe";
				}
				if (!preg_match("/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/ ", $_POST["password"])){ 
					$arrError[] = "Le mot de passe doit contenir au moins 8 caractères , un caractère spécial et une majuscule/minuscule";
				}
	
				if (!password_verify($_POST['confirmpassword'], $objUser->getPassword())){ // Tests sur la confirmation du mot de passe
					$arrError[]	= "Le mot de passe et sa confirmation ne sont pas identiques";
				}*/

				if ($objUser->getPhone() == ''){ // Tests sur le nom
					$arrError[]	= "Merci de renseigner un numéro de téléphone";
				}

				if ($objUser->getBirthday() == ''){ // Tests sur le nom
					$arrError[]	= "Merci de renseigner une date de naissance";
				}

				if ($objUser->getAddress() == ''){ // Tests sur le nom
					$arrError[]	= "Merci de renseigner une adresse";
				}

				if ($objUser->getCityId() == ''){ // Tests sur le nom
					$arrError[]	= "Merci de renseigner une ville";
				}
				if ($boolPersonalData == ''){ // Case d'autorisation de traitement des données personnelles
					$arrError[]	= "Merci d'accepter le traitement des données transmises";
				}
				
				// Si aucune erreur on l'insert en BDD
				if (count($arrError) == 0){ 
					$objUserManager = new UserManager;
					if($objUserManager->updateUser($objUser)){
						// Mettre à jour la session, si compte de l'utilisateur connecté
						if($_SESSION['user']['id'] == $objUser->getId()){
							$_SESSION['user']['firstname'] = $objUser->getFirstName();
						}
						header("Location:index.php");
					}else{
						$arrError[]	= "Erreur lors de l'ajout";
					}
				}
			}else{
				// Récupérer les informations de l'utilisateur qui est en session, dans la BDD 				
				$arrUser 		= $objUserManager->getUser();
				
				// Hydrater l'objet avec la méthode de l'entité
				$objUser->hydrate($arrUser);
				$intId 			= $objUser->getId();	
				$arrRole 		= $objRoleManager->getRoleId();
			}
			//liste des villes dans le formulaire
			foreach($arrCity as $arrDetCity){
				$objCity = new City;
				$objCity->hydrate($arrDetCity);
				if ($objUser->getCityId() == $objCity->getId()) {
					$arrSelected[] = $objCity->getId();
				}
				//$objCity->selected = ($intCityId == $objCity->getId())?"selected":"";
				$arrCityToDisplay[] = $objCity;
			}

			//liste des role dans le formulaire
			foreach($arrRole as $arrDetRole){

				$objRole = new Role;
				$objRole->hydrate($arrDetRole);
				if ($objUser->getRoleId() == $objRole->getId()) {
					$arrSelectedRole[] = $objRole->getId();
				}
				//$objCity->selected = ($intCityId == $objCity->getId())?"selected":"";
				$arrRoleToDisplay[] = $objRole;
				
			}
			
			// Si le formulaire est envoyé, traiter celui-ci pour pour modification en BDD
			$this->_arrData['intId']				= $intId;
			$this->_arrData['arrSelected']			= $arrSelected;
			$this->_arrData['arrSelectedRole']		= $arrSelectedRole;
			$this->_arrData['arrCityToDisplay']		= $arrCityToDisplay;
			$this->_arrData['arrRoleToDisplay']		= $arrRoleToDisplay;
			$this->_arrData['objUser']				= $objUser;
			$this->_arrData['arrError']				= $arrError;
			$this->_arrData['strTitle']				= "Créer un compte";
			$this->_arrData['strPage']				= "edit_account";
			$this->display("inscription");

		}

		//_________________________________________________________________________________________________________

		/**
		* Page liste des utilisateurs à consulter pour l'admin
		*/
		public function list_user(){
			if (	
				// utilisateur non connecté
				(!isset($_SESSION['user'])) 
			||  
				// utilisateur non admin qui veut changer un autre compte
				(isset($_GET['id'])!= $_SESSION['user']['id'] && $_SESSION['user']['role'] != 1) 
		   		){
					header("Location:index.php?ctrl=error&action=error_403");
			}
			
			// Récupération des utilisateurs
			$objUserManager = new UserManager;
			$arrUsers = $objUserManager->findUser();
			
			// Liste des utilisateurs en mode objet
			$arrUsersToDisplay = array();
			foreach($arrUsers as $arrDetUser){
				$objUser = new User;
				$objUser->hydrate($arrDetUser);
				$arrUsersToDisplay[] = $objUser;
				
			}
			// Affichage
			$this->_arrData['strTitle']					= "Liste des utilisateurs";
			$this->_arrData['strPage']					= "list_user";
			$this->_arrData['arrUsersToDisplay']		= $arrUsersToDisplay;
			$this->display("list_user");
		}

		//_________________________________________________________________________________________________________

		/**
		* Méthode de suppression d'un utilisateur
		*/
		public function DeleteUser(){
			if (// utilisateur non connecté
                (!isset($_SESSION['user'])) 
            ||
                // utilisateur non admin qui veut changer un autre compte
                (isset($_GET['id']) && $_SESSION['user']['role'] != 1) ){
                header("Location:index.php?ctrl=error&action=error_403");
            }
			$objUser = new User;
			// Récupération des utilisateurs
			$objUserManager = new UserManager;
			$objUserManager->deleteUser($objUser);
			$arrUsers = $objUserManager->findUser();
			
			// Liste des utilisateurs en mode objet
		
			// Affichage
			header("Location:index.php?ctrl=user&action=list_user");
		}

		//_________________________________________________________________________________________________________

		/**
		* Page profil
		*/
		public function vueProfil(){

		// Création de l'objet User et UserManager
		$objUser 			= new User;
		$objUserManager 	= new UserManager;

			// Récupérer les informations de l'utilisateur 				
			$arrUser 		= $objUserManager->getUser();
					
			// Hydrater l'objet avec la méthode de l'entité
			$objUser->hydrate($arrUser);
			$intId 			= $objUser->getId();

		// Création de l'objet User et UserManager
		$objRole			= new Role;
		$objRoleManager 	= new RoleManager;

			// Récupérer les informations de l'utilisateur 				
			$arrRole 		= $objRoleManager->getRole();
					
			// Hydrater l'objet avec la méthode de l'entité
			$objRole->hydrate($arrRole);

		// Création de l'objet City et CityManager
		$objCity			= new City;
		$objCityManager 	= new CityManager;

			// Récupérer les informations de la ville de l'utilisateur	
			$arrCity 		= $objCityManager->getCity();
					
			// Hydrater l'objet avec la méthode de l'entité
			$objCity->hydrate($arrCity);

		
		// Création de l'objet Home et HomeManager
		$objHome 		= new Home;
		$objHomeManager = new HomeManager;

			// Récupérer les informations du type d'habitation de l'utilisateur	
			$arrHome		= $objHomeManager->getHome();
					
			// Hydrater l'objet avec la méthode de l'entité
			$objHome->hydrate($arrHome);

		// Création de l'objet ProposeManager, SitterManager, PetTypeManager
		$objProposeManager 	= new ProposeManager;
		$objSitterManager 	= new SitterManager;
		$objPetTypeManager 	= new PetTypeManager;

			// Récupérer les informations de la garde proposée par l'utilisateur	
			$arrPropose		= $objProposeManager->getPetsitterDisplay();
					
			// Déclaration des tableaux pour la vue 
			$arrPetTypeSitterToDisplay 	= array();
			$arrSitterToDisplay 		= array();
			$arrProposeToDisplay		= array();

			foreach ($arrPropose as $arrDetPropose) {
				$objPropose = new Propose;
				$objPropose->hydrate($arrDetPropose);				

				$intProposeId = $objPropose->getId();

			//______ Création de l'objet PetTypeSitter et PetTypeManager (pour la section Petsitter)
			$objPetTypeSitter 		= new Pet_type;

			// Récupérer les informations des types d'animaux que l'utilisateur	souhaite garder
			$arrPetTypeSitter		= $objPetTypeManager->getPetTypeSitter($intProposeId);
					
			// Hydrater l'objet avec la méthode de l'entité
			$objPetTypeSitter->hydrate($arrPetTypeSitter);

			

			//______ Création de l'objet Sitter 
			$objSitter 			= new Sitter;
			
			// Récupérer les informations des types de garde proposées par l'utilisateur	
			$arrSitter		= $objSitterManager->getSitter($intProposeId);
					
			// Hydrater l'objet avec la méthode de l'entité
			$objSitter->hydrate($arrSitter);

			//Tableaux d'affichage
			$arrSitterToDisplay[] 			= $objSitter;
			$arrPetTypeSitterToDisplay[] 	= $objPetTypeSitter;
			$arrProposeToDisplay[] 			= $objPropose;
			
			}
				


		// Création de l'objet PetManager
		$objPetManager 	= new PetManager;

			// Récupérer les informations des animaux de l'utilisateur	
			$arrPet		= $objPetManager->getPetDisplay();
			
						
			// Hydrater l'objet avec la méthode de l'entité
			$arrPetToDisplay = array();
			foreach ($arrPet as $arrDetPet) {
				$objPet = new Pet;
				$objPet->hydrate($arrDetPet);
				$arrPetToDisplay[] = $objPet;
			}

		// Création de l'objet ProposeManager, SitterManager, PetTypeManager
		$objPetManager 		= new PetManager;
		$objSexManager 		= new SexManager;

			// Récupérer les informations de la garde proposée par l'utilisateur	
			$arrPet		= $objPetManager->getPetDisplay();
					
			// Déclaration des tableaux pour la vue 
			$arrPetToDisplay 		= array();
			$arrPetTypeToDisplay 	= array();
			$arrSexToDisplay 		= array();

			foreach ($arrPet as $arrDetPet) {
				$objPet = new Pet;
				$objPet->hydrate($arrDetPet);

				$intPetId = $objPet->getId();

				//______Création de l'objet Sex et SexManager
				$objSex			= new Sex;
		
				// Récupérer les informations des animaux de l'utilisateur	
				$arrSex		= $objSexManager->getSex($intPetId);
							
				// Hydrater l'objet avec la méthode de l'entité
				$objSex->hydrate($arrSex);

				//_____Création de l'objet PetType et PetTypeManager (pour la section Animaux)
				$objPetType				= new Pet_type;

				// Récupérer les informations des types d'animaux que l'utilisateur	souhaite garder
				$arrPetType		= $objPetTypeManager->getPetType($intPetId);
						
				// Hydrater l'objet avec la méthode de l'entité
				$objPetType->hydrate($arrPetType);	

				//Tableaux d'affichage
				$arrPetToDisplay[] 			= $objPet;
				$arrPetTypeToDisplay[] 		= $objPetType;
				$arrSexToDisplay[] 			= $objSex;			

			}
			


		// Création de l'objet PictureManager
		$objPictureManager 	= new PictureManager;

			// Récupérer les informations des animaux de l'utilisateur	
			$arrPicture	= $objPictureManager->getPicture();
						
			// Hydrater l'objet avec la méthode de l'entité
			$arrPictureToDisplay = array();
			foreach ($arrPicture as $arrDetPicture) {
				$objPicture	= new Picture;
				$objPicture->hydrate($arrDetPicture);
				$arrPictureToDisplay[] = $objPicture;
			}


		//Affichage 

		$this->_arrData['objUser']				= $objUser;
		$this->_arrData['objRole']				= $objRole;	
		$this->_arrData['objCity']				= $objCity;	
		$this->_arrData['objHome']				= $objHome;	

		if ( $arrProposeToDisplay != array()) {			
			$this->_arrData['objSitter']			= $objSitter;	
			$this->_arrData['objPetTypeSitter']		= $objPetTypeSitter;	
		}

		$this->_arrData['arrPetToDisplay']					= $arrPetToDisplay;
		$this->_arrData['arrPictureToDisplay']				= $arrPictureToDisplay;
		$this->_arrData['arrSitterToDisplay']				= $arrSitterToDisplay;
		$this->_arrData['arrPetTypeSitterToDisplay']		= $arrPetTypeSitterToDisplay;
		
		$this->_arrData['arrProposeToDisplay']				= $arrProposeToDisplay;
		$this->_arrData['arrSexToDisplay']					= $arrSexToDisplay;
		$this->_arrData['arrPetTypeToDisplay']				= $arrPetTypeToDisplay;


		$this->_arrData['strTitle']	= "PetSitter - Vue Profil ".$objUser->getName()." ".$objUser->getFirstname();
		$this->_arrData['strPage']	= "vueProfil";
		$this->display("vueProfil");
		}

		//_________________________________________________________________________________________________________

		/**
		* Page liste des petsitters soumis à validation pour les modérateurs
		*/
		public function list_sitter(){
            
			if (	
				// utilisateur non connecté
				(!isset($_SESSION['user'])) 
			||  
				// utilisateur non admin qui veut changer un autre compte
				(isset($_GET['id'])!= $_SESSION['user']['id'] && $_SESSION['user']['role'] != 3) 
				   ){
					header("Location:index.php?ctrl=error&action=error_403");
			}
			
			
			// Récupération des utilisateurs
			$objProposeManager = new ProposeManager;
			$objUserManager = new UserManager;
			$arrUsers = $objProposeManager->findPetsitter();
			
			// Liste des utilisateurs en mode objet
			$arrUsersToDisplay = array();
			foreach($arrUsers as $arrDetUser){
				$objUser = new User;
				$objUser->hydrate($arrDetUser);
				$arrUsersToDisplay[] = $objUser;				
			}
			
			// Affichage
			$this->_arrData['strTitle']					    = "Liste des Sitter";
			$this->_arrData['strPage']					    = "list_sitter";
			$this->_arrData['arrUsersToDisplay']			= $arrUsersToDisplay;
			$this->display("list_sitter");
		}

		//_________________________________________________________________________________________________________

		/**
		* Méthode de validation d'un sitter
		*/
		public function ValidSitter(){
			if (// utilisateur non connecté
                (!isset($_SESSION['user'])) 
            ||
                // utilisateur non admin qui veut changer un autre compte
                (isset($_GET['id']) && $_SESSION['user']['role'] != 3) ){
                header("Location:index.php?ctrl=error&action=error_403");
            }
			

			// Création des objets Propose et ProposeManager
			$objPropose = new Propose;
			$objProposeManager = new ProposeManager;
			
			//Hydratation de l'objet propose
			$intPropId = $_GET['id'];
			$arrPetsitter = $objProposeManager->getPetsitterForValid($intPropId);
			$objPropose->hydrate($arrPetsitter);

			//Mise à jour de prop_valid de 0 à 1
			$objProposeManager->updatePetsitter($objPropose);
		
			//Redirection vers l'accueil
			header("Location:index.php?ctrl=user&action=list_sitter");
		}

	}