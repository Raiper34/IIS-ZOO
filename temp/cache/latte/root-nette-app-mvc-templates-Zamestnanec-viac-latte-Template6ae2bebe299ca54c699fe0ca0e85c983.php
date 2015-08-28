<?php
// source: C:\Users\Raiper34\Desktop\server\root\nette\app\mvc/templates/Zamestnanec/viac.latte

class Template6ae2bebe299ca54c699fe0ca0e85c983 extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('118ba062af', 'html')
;
// prolog Latte\Macros\BlockMacros
//
// block content
//
if (!function_exists($_b->blocks['content'][] = '_lb038e2b8113_content')) { function _lb038e2b8113_content($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
?><div class="row">
	<div class="col-md-1">
		<button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal1">
		  Editovať
		</button>
		<div class="modal fade" id="modal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <h4 class="modal-title" id="myModalLabel">Eitovať</h4>
		      </div>
		      <div class="modal-body">
<?php $_l->tmp = $_control->getComponent("editovatForm"); if ($_l->tmp instanceof Nette\Application\UI\IRenderable) $_l->tmp->redrawControl(NULL, FALSE); $_l->tmp->render() ?>
		      </div>
		    </div>
		  </div>
		</div>
	</div>
	<div class="col-md-1">
<?php $_l->tmp = $_control->getComponent("vymazatButton"); if ($_l->tmp instanceof Nette\Application\UI\IRenderable) $_l->tmp->redrawControl(NULL, FALSE); $_l->tmp->render() ?>
	</div>
</div>
<h3>Základné informácie:</h3>
<strong>Rodné číslo:</strong> <?php echo Latte\Runtime\Filters::escapeHtml($zamestnanec->RodneCislo, ENT_NOQUOTES) ?> <br>
<strong>Meno:</strong> <?php echo Latte\Runtime\Filters::escapeHtml($zamestnanec->meno, ENT_NOQUOTES) ?> <br>
<strong>Priezvisko:</strong> <?php echo Latte\Runtime\Filters::escapeHtml($zamestnanec->priezvisko, ENT_NOQUOTES) ?> <br>
<strong>Titul:</strong> <?php echo Latte\Runtime\Filters::escapeHtml($zamestnanec->titul, ENT_NOQUOTES) ?> <br>
<strong>Dátum narodenia:</strong> <?php echo Latte\Runtime\Filters::escapeHtml($zamestnanec->datumNarodenia, ENT_NOQUOTES) ?> <br>
<strong>Adresa:</strong> <?php echo Latte\Runtime\Filters::escapeHtml($zamestnanec->adresa, ENT_NOQUOTES) ?> <br>
<strong>Funkcia:</strong> <?php echo Latte\Runtime\Filters::escapeHtml($zamestnanec->funkcia, ENT_NOQUOTES) ?> <br>
<strong>IBAN:</strong> <?php echo Latte\Runtime\Filters::escapeHtml($zamestnanec->IBAN, ENT_NOQUOTES) ?> <br>

<h3>Spravuje umiestnenia:</h3>

<h3>Stará sa o zvieratá:</h3>

<h3>Testoval:</h3>
<?php
}}

//
// end of blocks
//

// template extending

$_l->extends = empty($_g->extended) && isset($_control) && $_control instanceof Nette\Application\UI\Presenter ? $_control->findLayoutTemplateFile() : NULL; $_g->extended = TRUE;

if ($_l->extends) { ob_start();}

// prolog Nette\Bridges\ApplicationLatte\UIMacros

// snippets support
if (empty($_l->extends) && !empty($_control->snippetMode)) {
	return Nette\Bridges\ApplicationLatte\UIRuntime::renderSnippets($_control, $_b, get_defined_vars());
}

//
// main template
//
if ($_l->extends) { ob_end_clean(); return $template->renderChildTemplate($_l->extends, get_defined_vars()); }
call_user_func(reset($_b->blocks['content']), $_b, get_defined_vars()) ; 
}}