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

	protected function createComponentEditovanieForm()
	{
		$form = (new EditovatUzivatelaForm($this->database))->createee();
		return $form;
	}

	public function actionDefault($id)
	{
		$zaznam = $this->database->table('pouzivatelia')->get($id);
		$this["editovanieForm"]->setDefaults($zaznam->toArray());
	}
}
