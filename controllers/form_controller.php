<?php
	/**
	* Controller des pages des formulaires
	* @author Timothée KERN
	* <ul>
	*	<li>Page Formulaire Nouveau PetSitter</li>
	*	<li>Page Formulaire Nouvel Animal</li>
	*	<li>Page Fais Garder Ton Animal</li>
	*	<li>Page Ajouter une Image</li>
	* </ul>
	* @author Jérémy GALLIPPI
	* <ul>
	*	<li>Page de modif d'un Animal</li>
	*	<li>Page d'affichage de la liste des animaux (vue Admin)</li>
	*	<li>Page d'affichage la liste des animaux de l'utilisateur</li>
	*	<li>Méthode de suppression d'un animal</li>
	* </ul>
	*/
	class Form_controller extends Base_controller{
		/**
		* Constructeur de la classe
		*/ 
		public function __construct(){
			//user (utilisé par le form "fais parti de nos PetSitter")
			require("models/user_manager.php"); 
			require("entities/users_entity.php");
			//pet_type (utilisé par les forms "fais parti de nos PetSitter" & "ajoute ton animal" & "fais garder ton animal")
			require("entities/pet_type_entity.php"); 
			require("models/pet_type_manager.php"); 
			//sitter (utilisé par le form "fais parti de nos PetSitter"  & "fais garder ton animal")
			require("entities/sitter_entity.php"); 
			require("models/sitter_manager.php"); 
			//home (utilisé par le form "fais parti de nos PetSitter")
			require("entities/home_entity.php"); 
			require("models/home_manager.php"); 
			//propose (utilisé par le form "fais parti de nos PetSitter")
			require("entities/propose_entity.php"); 
			require("models/propose_manager.php");
			//sex (utilisé par le form "ajoute ton animal")
			require("entities/sex_entity.php"); 
			require("models/sex_manager.php"); 
			//pet (utilisé par le form "ajoute ton animal")
			require("entities/pet_entity.php"); 
			require("models/pet_manager.php"); 
			//picture (utilisé par le form "ajoutez votre image")
			require("entities/picture_entity.php"); 
			require("models/picture_manager.php"); 
		}
		
		/**
		* Page Formulaire Nouveau PetSitter
		*/
		public function formNouvPetSitter(){
			if (	
				// utilisateur non connecté
				(!isset($_SESSION['user'])) 
			||  
				// utilisateur non admin qui veut changer un autre compte
				(isset($_GET['id']) && $_SESSION['user']['role'] != 1) 
		   ){
			header("Location:index.php?ctrl=error&action=error_403");
			}

			// Pour récupérer les informations dans le formulaire
			$arrPetTypeSelected = $_POST['pet_typeid']??array();
			$arrSitterSelected  = $_POST['sitterid']??array();
			$intHome		    = $_POST['homeid']??'';
			$intId 				= $_SESSION['user']['id'];
			$boolPersonalData 	=  $_POST['personal_data']??'';

			// Création de l'objet User
			$objUser = new User;
			$objUserManager = new UserManager;

			// Création de l'objet Propose
			$objPetsitter = new Propose;
			$objPetsitterManager = new ProposeManager;

			//Vérifie que le petsitter n'existe pas déjà
			$boolOK = $objPetsitterManager->getPetsitter($intId);
			if ($boolOK==true) {
				header("Location:index.php?ctrl=error&action=error_error_form_already_completed");
			}
			
			// Liste des types d'animaux
			$objPetTypeManager  = new PetTypeManager(); 
			$arrPetType 	    = $objPetTypeManager->findPetType(); 
			$arrCheckedPet		= array();
			
	 		foreach($arrPetType as $arrDetPetType){
		 		$objPetType = new Pet_type;
		 		$objPetType->hydrate($arrDetPetType);
		 		if (in_array($objPetType->getId(), $arrPetTypeSelected)) {
					$arrCheckedPet[] = $objPetType->getId();
				}
		 		$arrPetTypeToDisplay[] = $objPetType;
	 		}
			$this->_arrData['arrCheckedPet']		= $arrCheckedPet;
		 	$this->_arrData['arrPetTypeToDisplay']	= $arrPetTypeToDisplay;
		 	

		 	// Liste des types de garde		
			$objSitterManager  	= new SitterManager(); 
			$arrSitter	    	= $objSitterManager->findSitter();
			$arrCheckedSitter	= array();
			
			$arrSitterToDisplay = array();
			foreach($arrSitter as $arrDetSitter){
				$objSitter = new Sitter;
				$objSitter->hydrate($arrDetSitter);
				if (in_array($objSitter->getId(), $arrSitterSelected)) {
					$arrCheckedSitter[] = $objSitter->getId();
				}
				$arrSitterToDisplay[] = $objSitter;
			}
			$this->_arrData['arrCheckedSitter']		= $arrCheckedSitter;
			$this->_arrData['arrSitterToDisplay']	= $arrSitterToDisplay;


			// Liste des types de logements
			$objHomeManager  	= new HomeManager(); 
			$arrHome	    	= $objHomeManager->findHome();
			$arrCheckedHome		= array();
			
			$arrHomeToDisplay 	= array();
			foreach($arrHome as $arrDetHome){
				$objHome = new Home;
				$objHome ->hydrate($arrDetHome);
				if ($intHome == $objHome->getId()) {
					$arrCheckedHome[] = $objHome->getId();
				}
				$arrHomeToDisplay[] = $objHome;
			}
			$this->_arrData['arrCheckedHome']	= $arrCheckedHome;
			$this->_arrData['arrHomeToDisplay']	= $arrHomeToDisplay;

			$arrError = array(); // Tableau des erreurs initialisé
			// Si formulaire envoyé
			if (count($_POST) > 0) {
				// On teste les informations
				if ($arrPetTypeSelected != array() && $arrSitterSelected == array()){ // 1er test sur la combinaison des types de gardes aux types d'animaux
					$arrError[]	= "Merci de renseigner au moins un type de garde";
				}
				if ($arrPetTypeSelected == array() && $arrSitterSelected != array()){ // 2nd test sur la combinaison des types de gardes aux types d'animaux
					$arrError[]	= "Merci de renseigner au moins un type d'animal";
				}
				if ($arrPetTypeSelected == array() && $arrSitterSelected == array()){ // 2nd test sur la combinaison des types de gardes aux types d'animaux
					$arrError[]	= "Merci de renseigner au moins un type d'animal et un type de garde correspondante";
				}
				if ($boolPersonalData == ''){ // Case d'autorisation de traitement des données personnelles
					$arrError[]	= "Merci d'accepter le traitement des données transmises";
				}
		
				
				// Si aucune erreur on l'insert en BDD
				if (count($arrError) == 0){ 
					if ($intHome != '') {
						$objUser->setHomeId($intHome);
						$objUserManager->editHome($objUser, $intId); 
					}
					if ($arrPetTypeSelected != array() && $arrSitterSelected != array()) {
						foreach($arrPetTypeSelected as $intPetTypeSelected){
							foreach($arrSitterSelected as $intSitterSelected){
								$arrSelected = array('sitterid' => $intSitterSelected, 'pettypeid' => $intPetTypeSelected);

								$objPropose = new Propose;
								$objPropose->hydrate($arrSelected);
								$objPetsitterManager->addPetsitter($objPropose, $intId);
							}
						}
					}
					header("Location:index.php"); // Redirection page d'accueil
				}			

				
			}


			//Affichage
			$this->_arrData['objUser']			= $objUser;
			$this->_arrData['arrError']			= $arrError;
			$this->_arrData['strTitle']			= "Fais parti de nos PetSitter";
			$this->_arrData['strPage']			= "formNouvPetSitter";
			$this->display("formNouvPetSitter");
		
		}

		//_________________________________________________________________________________________________________

		/**
		* Page Formulaire Nouvel Animal
		*/
		public function formNouvAnimal (){
			if (	
				// utilisateur non connecté
				(!isset($_SESSION['user'])) 
			
		   		){
					header("Location:index.php?ctrl=error&action=error_403");
			}

			// Pour récupérer les informations dans le formulaire
			$boolPersonalData 	=  $_POST['personal_data']??'';
			$intId 				= $_SESSION['user']['id'];
			$arrSexSelected		= array();
			$arrPetTypeSelected	= array();

			// Création de l'objet Pet
			$objPet = new Pet;
			// Création de l'objet PetManager
			$objPetManager = new PetManager;

					
			$arrError = array(); // Tableau des erreurs initialisé
			if (count($_POST) > 0) { // Si le formulaire est envoyé
				// On hydrate l'objet
				$objPet->hydrate($_POST);
				// On teste les informations
				if ($objPet->getName() == ''){ // Tests sur le nom
					$arrError[]	= "Merci de renseigner un nom pour votre animal";
				}else if($objPetManager->pet_exist($objPet)){ // test si déjà existant
				$arrError[]	= "Cet animal a déjà été enregistré";
				}
				if ($boolPersonalData == ''){ // Case d'autorisation de traitement des données personnelles
					$arrError[]	= "Merci d'accepter le traitement des données transmises";
				}
				
				// Si aucune erreur on l'insert en BDD
				if (count($arrError) == 0){ 
					if($objPetManager->addPet($objPet, $intId)){
						header("Location:index.php"); // Redirection page d'accueil;
					}else{
						$arrError[]	= "Erreur lors de l'ajout";
					}
				}
			}
			
		 	// Liste des types d'animaux
			 $objPetTypeManager  = new PetTypeManager(); 
			 $arrPetType 	    = $objPetTypeManager->findPetType(); 
 
			  $arrPetTypeToDisplay = array();
			  foreach($arrPetType as $arrDetPetType){
				  $objPetType = new Pet_type;
				  $objPetType->hydrate($arrDetPetType);
				 if ($objPet->getTypeid() == $objPetType->getId()) {
					 $arrPetTypeSelected[] = $objPetType->getId();
				 }
				  $arrPetTypeToDisplay[] = $objPetType;
			  }
			 $this->_arrData['arrPetTypeSelected']	= $arrPetTypeSelected;
			  $this->_arrData['arrPetTypeToDisplay']	= $arrPetTypeToDisplay;
 
			 // Liste des sexes
			 $objSexManager  	= new SexManager(); 
			 $arrSex	    	= $objSexManager->findSex();
			 
			 $arrSexToDisplay = array();
			 foreach($arrSex as $arrDetSex){
				 $objSex = new Sex;
				 $objSex->hydrate($arrDetSex);
				 if ($objPet->getSexid() == $objSex->getId()) {
					 $arrSexSelected[] = $objSex->getId();
				 }
				 $arrSexToDisplay[] = $objSex;
			 }
			 $this->_arrData['arrSexSelected']		= $arrSexSelected;
			 $this->_arrData['arrSexToDisplay']		= $arrSexToDisplay;

			//Affichage
			$this->_arrData['objPet']		= $objPet;
			$this->_arrData['arrError']		= $arrError;
			$this->_arrData['strTitle']		= "Ajoute ton animal";
			$this->_arrData['strPage']		= "formNouvAnimal";
			$this->display("formNouvAnimal");
		}

		//_________________________________________________________________________________________________________

		/**
		* Page de modif d'un Animal
		*/
		public function modifNouvAnimal (){
			
			// utilisateur non connecté
			if ((!isset($_SESSION['user'])) )// utilisateur non admin qui veut changer un autre compte 
											
				{
					header("Location:index.php?ctrl=error&action=error_403");
			}
			if ($_GET['petuser']!= $_SESSION['user']['id']

				&& 	$_SESSION['user']['role'] != 1) {
				header("Location:index.php?ctrl=error&action=error_403");
			}
			
			// Pour récupérer les informations dans le formulaire
			$boolPersonalData 	=  $_POST['personal_data']??'';
			
			$arrSexSelected		= array();
			$arrPetTypeSelected	= array();

			// Création de l'objet Pet
			$objPet = new Pet;
			// Création de l'objet PetManager
			$objPetManager = new PetManager;

			//Initialisation du tableau d'erreurs			
		 	$arrPetTypeToDisplay = array();		
			
					
			$arrError = array(); // Tableau des erreurs initialisé
			if (count($_POST) > 0) { // Si le formulaire est envoyé
				// On hydrate l'objet
				$objPet->hydrate($_POST);
				// On teste les informations
				if ($objPet->getName() == ''){ // Tests sur le nom
					$arrError[]	= "Merci de renseigner un nom pour votre animal";
				}else if($objPetManager->pet_exist($objPet)){ // test si déjà existant
				$arrError[]	= "Cet animal a déjà été enregistré";
				}
				if ($boolPersonalData == ''){ // Case d'autorisation de traitement des données personnelles
					$arrError[]	= "Merci d'accepter le traitement des données transmises";
				}
				
				// Si aucune erreur on l'insert en BDD
				if (count($arrError) == 0){ 
					if($objPetManager->updatePet($objPet)){
						header("Location:index.php"); // Redirection page d'accueil;
					}else{
						$arrError[]	= "Erreur lors de l'ajout";
					}
				}
			


			}else {
				
				$intId 	= $_GET['id'];				
				$arrPet			= $objPetManager->getPet($intId);
				// Hydrater l'objet avec la méthode de l'entité
				
				$objPet->hydrate($arrPet);
					
			}

			// Liste des types d'animaux
			$objPetTypeManager  = new PetTypeManager(); 
			$arrPetType 	    = $objPetTypeManager->findPetType(); 
			foreach($arrPetType as $arrDetPetType){
				$objPetType = new Pet_type;
				$objPetType->hydrate($arrDetPetType);
			   if ($objPet->getTypeid() == $objPetType->getId()) {
				   $arrPetTypeSelected[] = $objPetType->getId();
			   }
				$arrPetTypeToDisplay[] = $objPetType;
			}

			// Liste des sexes
			$objSexManager  	= new SexManager(); 
			$arrSex	    		= $objSexManager->findSex();
			foreach($arrSex as $arrDetSex){
				$objSex = new Sex;
				$objSex->hydrate($arrDetSex);
				if ($objPet->getSexid() == $objSex->getId()) {
					$arrSexSelected[] = $objSex->getId();
				}
				$arrSexToDisplay[] = $objSex;
			}
			
			//Affichage
			$this->_arrData['arrPetTypeSelected']	= $arrPetTypeSelected;
		 	$this->_arrData['arrPetTypeToDisplay']	= $arrPetTypeToDisplay;
			$this->_arrData['arrSexSelected']		= $arrSexSelected;
			$this->_arrData['arrSexToDisplay']		= $arrSexToDisplay;
			$this->_arrData['objPet']				= $objPet;
			$this->_arrData['arrError']				= $arrError;
			$this->_arrData['strTitle']				= "Modifier un animal";
			$this->_arrData['strPage']				= "modifNouvAnimal";
			$this->display("formNouvAnimal");
		}

		//_________________________________________________________________________________________________________

		/**
		* Page d'affichage de la liste des animaux
		*/
		public function list_pet(){
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
			$objPetManager = new PetManager;
			$arrPet = $objPetManager->findPet();
			
			// Liste des utilisateurs en mode objet
			$arrPetToDisplay = array();
			foreach($arrPet as $arrDetPet){
				$objPet = new Pet;
				$objPet->hydrate($arrDetPet);
				$arrPetToDisplay[] = $objPet;
				
			}
			// Affichage
			$this->_arrData['strTitle']					= "Liste des animaux";
			$this->_arrData['strPage']					= "list_pet";
			$this->_arrData['arrPetToDisplay']			= $arrPetToDisplay;
			$this->display("list_pet");
		}

		//_________________________________________________________________________________________________________

		/**
		* Page d'affichage la liste des animaux de l'utilisateur
		*/
		public function list_petuser(){
			
			if (// utilisateur non connecté
                (!isset($_SESSION['user'])) 
            ||
                // utilisateur non admin qui veut changer un autre compte
                (isset($_GET['id']) && $_SESSION['user']['role'] != 1) ){
                header("Location:index.php?ctrl=error&action=error_403");
            }
			// Récupération des utilisateurs
			$objPetManager = new PetManager;
			$arrPet = $objPetManager->getPetDisplay();
	
			// Liste des utilisateurs en mode objet
			$arrPetToDisplay = array();

			foreach($arrPet as $arrDetPet){
				$objPet = new Pet;
				$objPet->hydrate($arrDetPet);
				$arrPetToDisplay[] = $objPet;	
			}
			// Affichage
			$this->_arrData['strTitle']					= "Liste des animaux";
			$this->_arrData['strPage']					= "list_pet";
			$this->_arrData['arrPetToDisplay']			= $arrPetToDisplay;
			$this->display("list_petuser");
		}

		//_________________________________________________________________________________________________________

		/**
		* Méthode de suppression d'un animal
		* @param int $intPetId Id de l'animal à supprimer
		*/
		public function DeletePet(){
			
			if (// utilisateur non connecté
                (!isset($_SESSION['user'])) 
            ||
                // utilisateur non admin qui veut changer un autre compte
                (isset($_GET['id']) && $_SESSION['user']['role'] != 1) ){
                header("Location:index.php?ctrl=error&action=error_403");
            }
			$intId 		= $_GET['id'];
			$objPet = new Pet;
			// Récupération des utilisateurs
			$objPetManager = new PetManager;
			$objPetManager->deletePet($intId);
			
			
			if ($_SESSION['user']['role'] == 1) {
				header("index.php?ctrl=form&action=list_pet");
			}
			else {
				header("index.php?ctrl=form&action=list_petuser");
			}
			
		}
		
		//_________________________________________________________________________________________________________

		
		/**
		* Page Fais Garder Ton Animal
		*/
		public function faisGarderTonAnimal(){	
		
			// Pour récupérer les informations dans le formulaire
		 	$arrPetTypeSelected = $_POST['animal']??array();
		 	$arrSitterSelected	= $_POST['garde']??array();
			$intCP 				= $_POST['cp']??'';

	 		// Liste des types d'animaux
			$objPetTypeManager  = new PetTypeManager(); 
			$arrPetType 	    = $objPetTypeManager->findPetType(); 
			$arrCheckedPet		= array();
			
	 		foreach($arrPetType as $arrDetPetType){
		 		$objPetType = new Pet_type;
		 		$objPetType->hydrate($arrDetPetType);
		 		if (in_array($objPetType->getId(), $arrPetTypeSelected)) {
					$arrCheckedPet[] = $objPetType->getId();
				}
		 		$arrPetTypeToDisplay[] = $objPetType;
	 		}
			$this->_arrData['arrCheckedPet']		= $arrCheckedPet;
		 	$this->_arrData['arrPetTypeToDisplay']	= $arrPetTypeToDisplay;

		 	// Liste des types de garde		
			$objSitterManager  	= new SitterManager(); 
			$arrSitter	    	= $objSitterManager->findSitter();
			$arrCheckedSitter	= array();
			
			$arrSitterToDisplay = array();
			foreach($arrSitter as $arrDetSitter){
				$objSitter = new Sitter;
				$objSitter->hydrate($arrDetSitter);
				if (in_array($objSitter->getId(), $arrSitterSelected)) {
					$arrCheckedSitter[] = $objSitter->getId();
				}
				$arrSitterToDisplay[] = $objSitter;
			}
			$this->_arrData['arrCheckedSitter']		= $arrCheckedSitter;
			$this->_arrData['arrSitterToDisplay']	= $arrSitterToDisplay;


			//Pour la recherche 		
			$arrResultPetsitter = array();
			if(count($_POST) >0){
		 		require("models/search_manager.php");
		 		$objSearchManager = new SearchManager();
		 		$arrResultPetsitter = $objSearchManager->findPetSitter();
			}
			$this->_arrData['arrResultPetsitter']	= $arrResultPetsitter;

			
		 	//Affichage
			$this->_arrData['intCP']	= $intCP; 
			$this->_arrData['strTitle']	= "PetSitter - Choisis ton PetSitter";
			$this->_arrData['strPage']	= "faisGarderTonAnimal";
			$this->display("faisGarderTonAnimal");
		}



		//_________________________________________________________________________________________________________

		
		/**
		* Page Ajouter une Image
		*/
		public function ajoutImg(){	
			if (!isset($_SESSION['user'])) { // utilisateur non connecté
				header("Location:index.php?ctrl=error&action=error_403");
			}
			
			//Récupère l'id de l'utilisteur pour être utilisé en paramètre
			$intId = $_GET['id']??$_SESSION['user']['id'];

			//Création de l'objet PictureManager
			$objPictureManager = New PictureManager;

			//Vérifie que l'utilisateur n'a pas déjà plus de 20 images d'enregistrés
			$boolOK = $objPictureManager->verifLimitImg($intId);
			if ($boolOK==true) {
				header("Location:index.php?ctrl=error&action=error_form_limit_img");
			}
			
			// Pour récupérer les informations dans le formulaire
			$boolPersonalData 	=  $_POST['personal_data']??'';
			
			//Création de l'objet
			$objPicture = new Picture;
			
			$arrError 	= array(); // Initialisation du tableau des erreurs
			if (count($_POST) > 0){ // si formulaire envoyé

				//Hydrate l'objet en fonction des données entrées dans le formulaire
				$objPicture->hydrate($_POST);
				//Récupère l'image mise dans le formulaire
				$arrImageInfos		= $_FILES['image']??array();

				// Tests erreurs
				if ($boolPersonalData == ''){ // Case d'autorisation de traitement des données personnelles
					$arrError[]	= "Merci d'accepter le traitement des données transmises";
				}
				if ($arrImageInfos['size'] == 0){ // Test sur fichier d'image donné
					$arrError[]	= "Merci de renseigner une image";
				}
				if (count($arrError)==0){ 
					// Sauvegarde de l'image sur le serveur
					$strNewName = $this->_photoName($arrImageInfos['name']);
					$boolOk 	= $this->_photoTraitement($arrImageInfos, $strNewName);
					
					if($boolOk){
						
						// Insertion en BDD, si pas d'erreurs
						$objManager 	= new PictureManager(); // instancier la classe
						$objPicture->setName($strNewName);
						$objPicture->setUserid($_SESSION['user']['id']);
						$objManager->addPicture($objPicture); 
						
						header("Location:index.php"); // Redirection page d'accueil
						
					}
				}
			}




			
		 	//Affichage
			$this->_arrData['objPicture']	= $objPicture;
			$this->_arrData['arrError']		= $arrError;
			$this->_arrData['strTitle']	= "Ajoutez votre image";
			$this->_arrData['strPage']	= "ajoutImg";
			$this->display("ajoutImg");
		}
				
		
		
	}

	

	