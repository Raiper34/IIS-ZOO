<?php
// source: C:\Users\Raiper34\Desktop\server\root\nette\app\mvc/templates/Umiestnenie/viac.latte

class Template2baf16022a76162f727b8e5f915c7511 extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('c3657ce9c5', 'html')
;
// prolog Latte\Macros\BlockMacros
//
// block content
//
if (!function_exists($_b->blocks['content'][] = '_lb3bf7c9700e_content')) { function _lb3bf7c9700e_content($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
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
<?php if ($mod) { $_l->tmp = $_control->getComponent("editovatVybehForm"); if ($_l->tmp instanceof Nette\Application\UI\IRenderable) $_l->tmp->redrawControl(NULL, FALSE); $_l->tmp->render() ;} else { $_l->tmp = $_control->getComponent("editovatKlietkuForm"); if ($_l->tmp instanceof Nette\Application\UI\IRenderable) $_l->tmp->redrawControl(NULL, FALSE); $_l->tmp->render() ;} ?>
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
<strong>Identifiačné číslo:</strong> <?php echo Latte\Runtime\Filters::escapeHtml($umiestnenie->IDUmiestnenia, ENT_NOQUOTES) ?> <br>
<strong>Názov:</strong> <?php echo Latte\Runtime\Filters::escapeHtml($umiestnenie->nazov, ENT_NOQUOTES) ?> <br>
<strong>Šírka:</strong> <?php echo Latte\Runtime\Filters::escapeHtml($umiestnenie->sirka, ENT_NOQUOTES) ?> <br>
<strong>Dĺžka:</strong> <?php echo Latte\Runtime\Filters::escapeHtml($umiestnenie->dlzka, ENT_NOQUOTES) ?> <br>
<strong>Výška:</strong> <?php echo Latte\Runtime\Filters::escapeHtml($umiestnenie->vyska, ENT_NOQUOTES) ?> <br>

<?php if ($klietka) { ?>
Umiestnenie je typu klietka <br>
<strong>Typ:</strong> <?php echo Latte\Runtime\Filters::escapeHtml($klietka->typ, ENT_NOQUOTES) ?> <br>
<strong>Podstielka:</strong> <?php echo Latte\Runtime\Filters::escapeHtml($klietka->podstielka, ENT_NOQUOTES) ?> <br>
<strong>Lokacia:</strong> <?php echo Latte\Runtime\Filters::escapeHtml($klietka->lokacia, ENT_NOQUOTES) ?> <br>
<?php } else { ?>
Umiestnenie je typu Vybeh <br>
<strong>Terén:</strong> <?php echo Latte\Runtime\Filters::escapeHtml($vybeh->teren, ENT_NOQUOTES) ?> <br>
<strong>Povrch:</strong> <?php echo Latte\Runtime\Filters::escapeHtml($vybeh->povrch, ENT_NOQUOTES) ?> <br>
<strong>Ohradenie:</strong> <?php echo Latte\Runtime\Filters::escapeHtml($vybeh->ohradenie, ENT_NOQUOTES) ?> <br>
<?php } ?>
<h3>V umiestnení sa nachádza:</h3>

<h3>Umiestnenie spravuje:</h3>
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