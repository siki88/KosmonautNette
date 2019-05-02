<?php

//declare(strict_types=1);

namespace App\Presenters;

use Nette;
use Nette\Application\UI;
use App\Model\UserManager;

class BasePresenter extends UI\Presenter{

    public $userManager;

    public function __construct(UserManager $userManager){
        $this->userManager = $userManager;
    }

}
