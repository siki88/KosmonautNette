<?php

//declare(strict_types=1);

namespace App\FrontModule\Presenters;

use App\FrontModule\Components\RegistrationControl;
use App\Presenters\BasePresenter;

class HomepagePresenter extends BasePresenter {


	public function renderDefault(): void{
		$this->template->users = $this->userManager->getPublicUsers()->fetchAll();
//		echo('<pre>');
//		var_dump($this->userManager->getPublicUsers());
//        echo('</pre>');
	}

    public function actionDefault(){

    }

    public function handleDelete($id){
        $this->userManager->deleteUser($id);
        $this->flashMessage('Kosmonaut smazán');
    }

    protected function createComponentRegistration(){
	    $control = new RegistrationControl($this->userManager);
        $this->flashMessage('Kosmonaut byl přidán');
	    return $control;
    }

    protected function createComponentEdit(){
        $control = new \EditControl();
        $this->flashMessage('Kosmonaut byl editován');
        return $control;
    }



}
