<?php
// source: C:\Users\Raiper34\Desktop\server\root\nette\app\mvc/templates/Umiestnenie/vypis.latte

class Templatef54e6e1464e04c86c5fdf56d7811ab04 extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('9b7e35a3f6', 'html')
;
// prolog Latte\Macros\BlockMacros
//
// block content
//
if (!function_exists($_b->blocks['content'][] = '_lbbf90cc1176_content')) { function _lbbf90cc1176_content($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
?><div class="row">
	<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal1">
	  Pridať výbeh
	</button>
	<div class="modal fade" id="modal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title" id="myModalLabel">Pridať výbeh</h4>
	      </div>
	      <div class="modal-body">
<?php $_l->tmp = $_control->getComponent("vytvoritVybehForm"); if ($_l->tmp instanceof Nette\Application\UI\IRenderable) $_l->tmp->redrawControl(NULL, FALSE); $_l->tmp->render() ?>
	      </div>
	    </div>
	  </div>
	</div>

	<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal2">
	  Pridať klietku
	</button>
	<div class="modal fade" id="modal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title" id="myModalLabel">Pridať klietku</h4>
	      </div>
	      <div class="modal-body">
<?php $_l->tmp = $_control->getComponent("vytvoritKliektuForm"); if ($_l->tmp instanceof Nette\Application\UI\IRenderable) $_l->tmp->redrawControl(NULL, FALSE); $_l->tmp->render() ?>
	      </div>
	    </div>
	  </div>
	</div>
</div>

<div class="row">
	<table class="table table-bordered table-hover">
	    <tr>
	        <th>Identifikačné číslo</th>
	        <th>Názov</th>
	    </tr>
<?php $iterations = 0; foreach ($umiestnenia as $umiestnenie) { ?>
	    <tr>
	        <td><?php echo Latte\Runtime\Filters::escapeHtml($umiestnenie->IDUmiestnenia, ENT_NOQUOTES) ?></td>
	        <td><?php echo Latte\Runtime\Filters::escapeHtml($umiestnenie->nazov, ENT_NOQUOTES) ?></td>
	        <td><?php $_l->tmp = $_control->getComponent("viacButton-$umiestnenie->IDUmiestnenia"); if ($_l->tmp instanceof Nette\Application\UI\IRenderable) $_l->tmp->redrawControl(NULL, FALSE); $_l->tmp->render() ?></td>
	    <tr>
<?php $iterations++; } ?>
	</table>
</div>
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