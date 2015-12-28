<?php
	namespace Album\Controller;
	
	use Zend\Mvc\Controller\AbstractActionController;
	use Zend\View\Model\ViewModel;
	use Album\Model\Album;     
	use Album\Form\AlbumForm;
	
	
	class AlbumController extends AbstractActionController
	{
		protected $albumTable;
		
		public function indexAction()
	    {
	         return new ViewModel(array(
	             'albums' => $this->getAlbumTable()->fetchAll(),
	         ));
	    }
	
		public function addAction()
		{
			// Instanciation d'un formulaire, on récupère un bouton submit que l'on renomme "Add"
			$form = new AlbumForm();
			$form->get('submit')->setValue('Add');
			
			// On regarde si les données on été envoyées
			$request = $this->getRequest();
			if ($request->isPost()) {
				
				// On créer un nouvel album (une ligne) et on récupère les données envoyées
				$album = new Album(); 
				$form->setInputFilter($album->getInputFilter());
				$form->setData($request->getPost());
			
				// Si les données envoyeés sont valides on sauvegarde les données dans le nouvel album
				if ($form->isValid()) {
					$album->exchangeArray($form->getData());
					$this->getAlbumTable()->saveAlbum($album);
			
					// Redirect to list of albums
					return $this->redirect()->toRoute('album');
				}
			}
			return array('form' => $form);
		}
	
	// Add content to this method:
     public function editAction()
     {
         $id = (int) $this->params()->fromRoute('id', 0);
         if (!$id) {
             return $this->redirect()->toRoute('album', array(
                 'action' => 'add'
             ));
         }

         // Get the Album with the specified id.  An exception is thrown
         // if it cannot be found, in which case go to the index page.
         try {
             $album = $this->getAlbumTable()->getAlbum($id);
         }
         catch (\Exception $ex) {
             return $this->redirect()->toRoute('album', array(
                 'action' => 'index'
             ));
         }

         $form  = new AlbumForm();
         $form->bind($album);
         $form->get('submit')->setAttribute('value', 'Edit');

         $request = $this->getRequest();
         if ($request->isPost()) {
             $form->setInputFilter($album->getInputFilter());
             $form->setData($request->getPost());

             if ($form->isValid()) {
                 $this->getAlbumTable()->saveAlbum($album);

                 // Redirect to list of albums
                 return $this->redirect()->toRoute('album');
             }
         }

         return array(
             'id' => $id,
             'form' => $form,
         );
     }
	
	public function deleteAction()
     {
         $id = (int) $this->params()->fromRoute('id', 0);
         if (!$id) {
             return $this->redirect()->toRoute('album');
         }

         $request = $this->getRequest();
         if ($request->isPost()) {
             $del = $request->getPost('del', 'No');

             if ($del == 'Yes') {
                 $id = (int) $request->getPost('id');
                 $this->getAlbumTable()->deleteAlbum($id);
             }

             // Redirect to list of albums
             return $this->redirect()->toRoute('album');
         }

         return array(
             'id'    => $id,
             'album' => $this->getAlbumTable()->getAlbum($id)
         );
     }
		
		public function getAlbumTable()
		{
			if (!$this->albumTable) {
				$sm = $this->getServiceLocator();
				$this->albumTable = $sm->get('Album\Model\AlbumTable');
			}
			return $this->albumTable;
		}
	}