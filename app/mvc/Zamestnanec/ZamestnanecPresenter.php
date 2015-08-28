<?php

namespace App\Presenters;

use Nette;
use Nette\Application\UI\Form;
use Nette\Application\UI\Multiplier;
use App\Forms\VytvoritZamestnancaForm;
use App\Forms\VymazatZamestnancaButton;
use App\Forms\ViacButton;
use App\Forms\EditovatZamestnancaForm;

/*
 * Stranky s uzivatelmi a prislusnych akciami
 */
class ZamestnanecPresenter extends BasePresenter
{
	private $database;
	private $tovarna;
	private $RodneCislo;

	public function __construct(Nette\Database\Context $databaza)
	{
		$this->database = $databaza;
	}

	public function actionDefault()
	{
		$this->redirect('Zamestnanec:vypis');
	}

	/************************************ Vypis ****************************************/
	/*
	 * Stranka s vypisom uzivatelov a formom na pridavanie uzivatelov
	 */
	public function renderVypis()
	{
		$this->template->zamestnanci = $this->database->table('zamestnanec');
	}

	/*
	 * Vytvorenie formu na vytvorenie uzaivatela
	 */
	protected function createComponentVytvoritForm()
	{
		$form = (new VytvoritZamestnancaForm($this->database, $this))->vytvorit();
		return $form;
	}

	/*
	 * Vytvorenie buttonu na eitovanie uzivatela
	 */
	protected function createComponentViacButton()
	{
		return new Multiplier(function ($RodneCislo)
		{
			$form = (new ViacButton($this->database, $RodneCislo, 'Zamestnanec:viac'))->vytvorit();
			return $form;
		});
	}

	/********************************** Viac **********************************/

	public function renderViac($RodneCislo)
	{
		$this->template->zamestnanec = $this->database->table('zamestnanec')->get($RodneCislo);
	}

	public function actionViac($RodneCislo)
	{
		$this->RodneCislo = $RodneCislo;
		$zaznam = $this->database->table('zamestnanec')->get($RodneCislo);
		$zaznam = $zaznam->toArray();

		//Prevod datumu z databaze na korespondujuci datum pre uzivatela
		$datum = date_parse($zaznam['datumNarodenia']); //iba roky mesiace a dni
		$rok =  $datum['year'];
		$mesiac = $datum['month'];
		$den = $datum['day'];
		$zaznam['datumNarodenia'] = $rok . '-' . $mesiac . '-' . $den;

		$this["editovatForm"]->setDefaults($zaznam);
		$this->tovarna->RodneCislo = $RodneCislo;
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
		$this->redirect('Zamestnanec:editovat', $this->RodneCislo);
	}

	protected function createComponentVymazatButton()
	{
		$form = new Form;
		$form->addSubmit('vymazat', 'Vymazať')->setAttribute('class', 'btn btn-danger');

		$form->onSuccess[] = array($this, 'uspesneVymazatButton');
		return $form;
	}

	public function uspesneVymazatButton(Form $form, $hodnoty)
	{
		$this->database->table('zamestnanec')->where('RodneCislo', $this->RodneCislo)->delete();
		$form->getPresenter()->redirect('Zamestnanec:vypis');
	}

	protected function createComponentEditovatForm()
	{
		$this->tovarna = new EditovatZamestnancaForm($this->database, $this->RodneCislo);
		$form = $this->tovarna->vytvorit();
		return $form;
	}

}
