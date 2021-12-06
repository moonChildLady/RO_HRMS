<?php
Yii::import('zii.widgets.CMenu', true);

class MainMenu extends CMenu
{
	/*public function ActiveClass($requestController)
	{
		//$current_file_name = basename($_SERVER['REQUEST_URI'], ".php");
		$controllerName = Yii::app()->controller->action->id;
		
		if ( $controllerName != $requestController){
			return 'active_submenu';
		}
	}*/

    public function init()
    {
		//$academicyear = Controller::academicyear();
		if(!Yii::app()->user->isGuest){
		$this->render('MainMenuContent');
		}
		
		
		parent::init();
		
    }
}
