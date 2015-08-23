<?php

namespace App\Presenters;

use Nette;
use Nette\Application\UI\Form;
use Nette\Application\UI\Multiplier;
use App\Forms\ViacButton;
use App\Forms\VytvoritDruhForm;

/*
 * Stranky s druhmi zvierat a prislusnych akciami
 */
class DruhPresenter extends BasePresenter
{
	private $database;

	public function __construct(Nette\Database\Context $databaza)
	{
		$this->database = $databaza;
	}

	public function actionDefault()
	{
		$this->redirect('Druh:vypis');
	}

	/******************* Vypis ***********************/
	public function renderVypis()
	{
		$this->template->druhy = $this->database->table('druhZivocicha');
	}

	protected function createComponentVytvoritForm()
	{
		$form = (new VytvoritDruhForm($this->database, $this))->vytvorit();
		return $form;
	}

	protected function createComponentViacButton()
	{
		return new Multiplier(function ($Id)
		{
			$form = (new ViacButton($this->database, $Id, 'Druh:viac'))->vytvorit();
			return $form;
		});
	}

	/******************* Viac ************************/


	/***************** Eitovat ***********************/

}
