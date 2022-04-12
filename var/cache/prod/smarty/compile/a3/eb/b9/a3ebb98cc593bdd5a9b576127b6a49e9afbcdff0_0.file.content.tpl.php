<?php
/* Smarty version 3.1.43, created on 2022-04-10 15:59:51
  from '/var/www/html/admin297ik22uw/themes/default/template/content.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.43',
  'unifunc' => 'content_62533737b59175_36250188',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'a3ebb98cc593bdd5a9b576127b6a49e9afbcdff0' => 
    array (
      0 => '/var/www/html/admin297ik22uw/themes/default/template/content.tpl',
      1 => 1649619915,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_62533737b59175_36250188 (Smarty_Internal_Template $_smarty_tpl) {
?><div id="ajax_confirmation" class="alert alert-success hide"></div>
<div id="ajaxBox" style="display:none"></div>

<div class="row">
	<div class="col-lg-12">
		<?php if ((isset($_smarty_tpl->tpl_vars['content']->value))) {?>
			<?php echo $_smarty_tpl->tpl_vars['content']->value;?>

		<?php }?>
	</div>
</div>
<?php }
}
