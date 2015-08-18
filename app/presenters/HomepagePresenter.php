<?php

namespace App\Presenters;

use Nette;
use Nette\Application\UI\Form;
use Nette\Application\UI\Multiplier;
use App\Forms\VytvoritUzivatelaForm;
use App\Forms\VymazatUzivatelaForm;
use App\Forms\EditovatUzivatelaForm;
use App\Forms\PrihlasenieForm;


class HomepagePresenter extends BasePresenter
{
	private $database;

	public function __construct(Nette\Database\Context $database)
	{
		$this->database = $database;
	}

	public function renderDefault()
	{
		$user = $this->getUser();
		//$user->login('god', 'god');

		/*$this->template->posts = $this->database->table('posts')->order('created_at DESC')->limit(5);
		$this->template->pouzivatel = $user->getIdentity()->meno;*/
		$this->template->pouzivatelia = $this->database->table('pouzivatelia');
	}

	/*protected function createComponentCommentForm()
	{
	    $form = (new \App\Forms\SignFormFactory())->create();
	    return $form;
	}*/

	protected function createComponentVytvoritUzivatela()
	{
		$form = (new VytvoritUzivatelaForm($this->database, $this))->create();
		return $form;
	}

	protected function createComponentPrihlasenie()
	{
		$form = (new PrihlasenieForm($this->database, $this))->create();
		return $form;
	}

	protected function createComponentVymazatUzivatela()
	{
		return new Multiplier(function ($id)
		{
			$form = (new VymazatUzivatelaForm($this->database, $this, $id))->create();
			return $form;
		});
	}

	protected function createComponentEditovatUzivatela()
	{
		return new Multiplier(function ($id)
		{
			$form = (new EditovatUzivatelaForm($this->database))->create($id);
			return $form;
		});
	}

}
