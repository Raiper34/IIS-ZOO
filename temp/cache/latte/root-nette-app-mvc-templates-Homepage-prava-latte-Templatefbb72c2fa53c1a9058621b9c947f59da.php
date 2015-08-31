<?php
// source: C:\Users\Raiper34\Desktop\server\root\nette\app\mvc/templates/Homepage/prava.latte

class Templatefbb72c2fa53c1a9058621b9c947f59da extends Latte\Template {
function render() {
foreach ($this->params as $__k => $__v) $$__k = $__v; unset($__k, $__v);
// prolog Latte\Macros\CoreMacros
list($_b, $_g, $_l) = $template->initialize('b4a9a44a9e', 'html')
;
// prolog Latte\Macros\BlockMacros
//
// block content
//
if (!function_exists($_b->blocks['content'][] = '_lb096516a07d_content')) { function _lb096516a07d_content($_b, $_args) { foreach ($_args as $__k => $__v) $$__k = $__v
?><div class="row">
	<div class="alert alert-danger" role="alert">
  		<span class="sr-only">Error:</span>
  		<h3 class="text-center"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>Na vykonanie tejto akcie nemáte dostatočné práva!<h3>
	</div>
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