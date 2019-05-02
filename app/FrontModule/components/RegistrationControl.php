<?php

namespace App\FrontModule\Components;

use Nette\Application\UI,
    App\Model;

class RegistrationControl extends UI\Control {

    /** @var Model\UserManager @inject */
    public $userManager;

    public function __construct(Model\UserManager $userManager){
        $this->userManager = $userManager;
    }

    public function render(){
        $this->template->render(__DIR__.'/RegistrationControl.latte');
    }

    protected function createComponentRegistrationForm(){
        $form = new UI\Form();
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
        $form->addSubmit('send', 'Odeslat')
            ->setAttribute('class', 'uk-button uk-button-primary');
        $form->addProtection('Vypršel časový limit, odešlete formulář znovu');
        $form->onSuccess[] = [$this, 'registrationFormSucceeded'];
        return $form;
    }

    public function registrationFormSucceeded(UI\Form $form){
        $values = $form->getValues();

        $this->userManager->add($values->name,$values->surname,$values->birth,$values->skills);

        $this->redirect('this');
    }

}