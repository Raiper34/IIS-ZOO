<?php

namespace App\Presenters;

use Nette;
use Nette\Application\UI\Form;
use Nette\Application\UI\Multiplier;
use App\Forms\VytvoritZivocichaForm;
use App\Forms\ViacButton;
use App\Forms\EditovatZivocichaForm;

/*
 * Stranky s uzivatelmi a prislusnych akciami
 */
class ZivocichPresenter extends BasePresenter
{
	private $database;
	private $tovarna;
	private $Id;

	public function __construct(Nette\Database\Context $databaza)
	{
		$this->database = $databaza;
	}

	public function actionDefault()
	{
		$this->redirect('Zamestnanec:vypis');
	}

	/************************************ Vypis ****************************************/
	public function renderVypis()
	{
		$this->template->zivocichi = $this->database->table('zivocich');
	}

	protected function createComponentVytvoritForm()
	{
		$form = (new VytvoritZivocichaForm($this->database, $this))->vytvorit();
		return $form;
	}

	protected function createComponentViacButton()
	{
		return new Multiplier(function ($Id)
		{
			$form = (new ViacButton($this->database, $Id, 'Zivocich:viac'))->vytvorit();
			return $form;
		});
	}

	/********************************** Viac **********************************/

	public function renderViac($Id)
	{
		$this->template->zivocich = $this->database->table('zivocich')->get($Id);
		$this->template->druh = $this->database->table('druhZivocicha')->get($this->template->zivocich->IDDruhuZivocicha);
		$this->template->umiestnenie = $this->database->table('umiestnenie')->get($this->template->zivocich->IDUmiestnenia);
	}

	public function actionViac($Id)
	{
		$this->Id = $Id;
	}
	protected function createComponentEditovatButton()
	{
		$form = new Form;
		$form->addSubmit('editovat', 'Editovať')->setAttribute('class', 'btn btn-success');

		$form->onSuccess[] = array($this, 'uspesneEditovatButton');
		return $form;
	}

	public function uspesneEditovatButton(Form $form, $hodnoty)
	{
		$this->redirect('Zivocich:editovat', $this->Id);
	}

	protected function createComponentVymazatButton()
	{
		$form = new Form;
		$form->addSubmit('vymazat', 'Vymazať')->setAttribute('class', 'btn btn-danger');;

		$form->onSuccess[] = array($this, 'uspesneVymazatButton');
		return $form;
	}

	public function uspesneVymazatButton(Form $form, $hodnoty)
	{
		$this->database->table('zivocich')->where('IDZivocicha', $this->Id)->delete();
		$form->getPresenter()->redirect('Zivocich:vypis');
	}

	/********************************* Editovat  ***********************************/
	public function actionEditovat($Id)
	{
		$this->Id = $Id;
		$zaznam = $this->database->table('zivocich')->get($Id);
		$zaznam = $zaznam->toArray();

		//Prevod datumu z databaze na korespondujuci datum pre uzivatela
		$datum = date_parse($zaznam['datumNarodenia']); //iba roky mesiace a dni
		$rok =  $datum['year'];
		$mesiac = $datum['month'];
		$den = $datum['day'];
		$zaznam['datumNarodenia'] = $rok . '-' . $mesiac . '-' . $den;

		$datum = date_parse($zaznam['datumUmrtia']); //iba roky mesiace a dni
		$rok =  $datum['year'];
		$mesiac = $datum['month'];
		$den = $datum['day'];
		$zaznam['datumUmrtia'] = $rok . '-' . $mesiac . '-' . $den;

		$this["editovatForm"]->setDefaults($zaznam);
		$this->tovarna->Id = $Id;
	}

	protected function createComponentEditovatForm()
	{
		$this->tovarna = new EditovatZivocichaForm($this->database, $this->Id);
		$form = $this->tovarna->vytvorit();
		return $form;
	}
	

}
