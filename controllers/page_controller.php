<?php
	/**
	* Controller des pages
	* @author Timothée KERN
	*/
	class Page_controller extends Base_controller{
		
		/**
		* Page Accueil
		*/
		public function accueil(){
			$this->_arrData['strTitle']	= "PetSitter";
			$this->_arrData['strPage']	= "index";
			$this->display("index");
		}

		/**
		* Page Contact
		*/
		public function contact(){
			$this->_arrData['strTitle']	= "PetSitter - Contact";
			$this->_arrData['strPage']	= "contact";
			$this->display("contact");
		}

		/**
		* Page Deviens PetSitter
		*/
		public function deviensPetSitter(){
			$this->_arrData['strTitle']	= "PetSitter - Devenir PetSitter";
			$this->_arrData['strPage']	= "deviensPetSitter";
			$this->display("deviensPetSitter");
		}
	

		/**
		* Page Galerie
		*/
		public function galerie(){
			$this->_arrData['strTitle']	= "PetSitter - Galerie photo";
			$this->_arrData['strPage']	= "galerie";
			$this->display("galerie");
		}

		
		
		/**
		* Page Mentions légales
		*/
		public function mentions(){
			$this->_arrData['strTitle']	= "Mentions légales";
			$this->_arrData['strPage']	= "mentions";
			$this->display("mentions");
		}

		/**
		* Page Plan du site
		*/
		public function planDuSite(){
			$this->_arrData['strTitle']	= "PetSitter - Plan de site";
			$this->_arrData['strPage']	= "planDuSite";
			$this->display("planDuSite");
		}

	}