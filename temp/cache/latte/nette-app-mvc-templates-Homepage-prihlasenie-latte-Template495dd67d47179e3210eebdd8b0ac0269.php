<?php
// source: C:\Users\Raiper34\Desktop\server\root\nette\app\mvc/templates/Homepage/prihlasenie.latte

class Template495dd67d47179e3210eebdd8b0ac0269 extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('28aaf8a1ca', 'html')
;
// prolog Latte\Macros\BlockMacros
//
// block content
//
if (!function_exists($_b->blocks['content'][] = '_lb7154d6de8d_content')) { function _lb7154d6de8d_content($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
?><div class="row">
	<div class="col-md-4"></div>
	<div class="col-md-4">
		<div class="row">
			<h1 class="text-center">IIS ZOO FIT</h1>
			<h3 class="text-center">Prihlásenie</h3>
<?php $_l->tmp = $_control->getComponent("prihlasenie"); if ($_l->tmp instanceof Nette\Application\UI\IRenderable) $_l->tmp->redrawControl(NULL, FALSE); $_l->tmp->render() ?>
		</div>
	</div>
	<div class="col-md-4"></div>
</div>

<img src="<?php echo Latte\Runtime\Filters::escapeHtml(Latte\Runtime\Filters::safeUrl($basePath), ENT_COMPAT) ?>/images/elephant.gif" id="slon" alt="slon" class="hidden-xs">

<footer id="myfooter" class="hidden-xs">
<strong>Vytvoril Filip Gulán a Euard Rybár 2015</strong>
</footer>

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
?>

<?php if ($_l->extends) { ob_end_clean(); return $template->renderChildTemplate($_l->extends, get_defined_vars()); }
call_user_func(reset($_b->blocks['content']), $_b, get_defined_vars()) ; 
}}