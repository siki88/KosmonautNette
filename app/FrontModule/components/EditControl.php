<?php

use Nette\Application\UI;

class EditControl extends UI\Control {

    public function render($editUser = null){
        $this->template->editUser = $editUser;
        $this->template->render(__DIR__.'/EditControl.latte');
    }

    protected function createComponentEditForm(){
        $form = new UI\Form;

        //  $form->getElementPrototype()->class = 'myLogRegForm';

        $form->addText('name', 'Jméno')
            ->setAttribute('class', 'uk-input')
            ->setRequired('Zadejte prosím jméno');

        $form->addText('surname', 'Příjmení')
            ->setAttribute('class', 'uk-input')
            ->setRequired('Zadejte prosím příjmení');

        $form->addText('birth', 'Datum narození')
            ->setAttribute('class', 'uk-input')
            ->setRequired('Zadejte prosím datum narození')
            ->setType('date')
            ->setDefaultValue((new \DateTime)->format('Y-m-d hh:mm:ss'));

        $form->addText('skills', 'Vaše schopnost')
            ->setAttribute('class', 'uk-input')
            ->setRequired('Zadejte prosím vaši schopost');

        $form->addSubmit('send', 'Editovat')
            ->setAttribute('class', 'uk-button uk-button-primary');

        $form->addProtection('Vypršel časový limit, odešlete formulář znovu');

        $form->onSuccess[] = [$this, 'editFormSucceeded'];

        return $form;
    }

    public function editFormSucceeded(UI\Form $form){
        $values = $form->getValues();

        $this->redirect('this');
    }

}