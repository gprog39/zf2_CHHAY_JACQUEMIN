<?php

	namespace Album\Model;
	
	use Zend\InputFilter\InputFilter;
	use Zend\InputFilter\InputFilterAwareInterface;
	use Zend\InputFilter\InputFilterInterface;
	
	class Album
	{
		public $id;
		public $artist;
		public $title;
		protected $inputFilter;
	
		public function exchangeArray($data)
		{
			$this->id     = (!empty($data['id'])) ? $data['id'] : null;
			$this->artist = (!empty($data['artist'])) ? $data['artist'] : null;
			$this->title  = (!empty($data['title'])) ? $data['title'] : null;
			//$this->id_user  = (!empty($data['id_user'])) ? $data['id_user'] : null;
		}
		
		public function getArrayCopy()
		{
			return get_object_vars($this);
		}
		
		// On ajoute des filtres au zones d'entrées dans les formulaires pour traiter les erreurs et les saisies malveillantes
		public function setInputFilter(InputFilterInterface $inputFilter)
		{
			throw new \Exception("Not used");
		}
		
		public function getInputFilter()
		{
			if (!$this->inputFilter) {
				$inputFilter = new InputFilter();
		
				$inputFilter->add(array(
						'name'     => 'id',
						'required' => true,
						'filters'  => array(
								array('name' => 'Int'),
						),
				));
		
				$inputFilter->add(array(
						'name'     => 'artist',
						'required' => true,
						'filters'  => array(
								// Enlève les codes HTML et les blancs
								array('name' => 'StripTags'),
								array('name' => 'StringTrim'),
						),
						'validators' => array(
								array(
										'name'    => 'StringLength',
										'options' => array(
												'encoding' => 'UTF-8',
												'min'      => 1,
												'max'      => 100,
										),
								),
						),
				));
		
				$inputFilter->add(array(
						'name'     => 'title',
						'required' => true,
						'filters'  => array(
								array('name' => 'StripTags'),
								array('name' => 'StringTrim'),
						),
						'validators' => array(
								array(
										'name'    => 'StringLength',
										'options' => array(
												'encoding' => 'UTF-8',
												'min'      => 1,
												'max'      => 100,
										),
								),
						),
				));
				
				/*
				$inputFilter->add(array(
						'name'     => 'id_user',
						'required' => true,
						'filters'  => array(
								array('id_user' => 'Int'),
						),
				));
				*/
		
				$this->inputFilter = $inputFilter;
			}
		
			return $this->inputFilter;
		}
		
	}