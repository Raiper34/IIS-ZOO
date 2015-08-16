<?php

namespace App\Presenters;

use Nette;
use Nette\Application\UI\Form;
use Nette\Application\UI\Multiplier;
use App\Forms\EditovatUzivatelaForm;

class EditovaniePresenter extends BasePresenter
{
	private $database;
	private $id;

	public function __construct(Nette\Database\Context $database)
	{
		$this->database = $database;
	}

	public function renderDefault($id)
	{
		$this->id = $id;
	}

	protected function createComponentEditovanie()
	{
		$form = (new EditovatUzivatelaForm($this->database, $this, $this->id))->createee();
		return $form;
	}

}
