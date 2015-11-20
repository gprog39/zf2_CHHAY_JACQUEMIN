<?php

	// Classe pour les formulaires
	// note : Méthode d'envoi par déf : POST pour mettre en GET : $this->setAttribute('method', 'GET');

	namespace Album\Form;
	
	use Zend\Form\Form;
	
	class AlbumForm extends Form
	{
		public function __construct($name = null)
		{
			// we want to ignore the name passed
			parent::__construct('album');
	
			// Création de 4 élément de formulaire : id, titre, artiste, bouton d'envoi
			$this->add(array(
					'name' => 'id',
					'type' => 'Hidden',
			));
			$this->add(array(
					'name' => 'title',
					'type' => 'Text',
					'options' => array(
							'label' => 'Title',
					),
			));
			$this->add(array(
					'name' => 'artist',
					'type' => 'Text',
					'options' => array(
							'label' => 'Artist',
					),
			));
			$this->add(array(
					'name' => 'submit',
					'type' => 'Submit',
					'attributes' => array(
							'value' => 'Go',
							'id' => 'submitbutton',
					),
			));
		}
	}
