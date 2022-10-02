<?php
// cntnd_html_output
$cntnd_module = "cntnd_html";

// assert framework initialization
defined('CON_FRAMEWORK') || die('Illegal call: Missing framework initialization - request aborted.');

// editmode
$editmode = cRegistry::isBackendEditMode();

// input/vars
$text = "CMS_HTML[1]";
$truncate = (bool) "CMS_VALUE[1]";
$lines = (int) "CMS_VALUE[2]";
if (empty($lines)){
  $lines = 5;
}
$own_js = (bool) "CMS_VALUE[3]";
$uuid = 'idart-'.$idart.'-'.rand();

// includes
if ($editmode) {
    cInclude('module', 'includes/style.cntnd_html.php');
}
if (!$editmode && $truncate){
	cInclude('module', 'includes/script.cntnd_html_output.php');
}

// module
if ($editmode){
    echo '<span class="module_box"><label class="module_label">'.mi18n("MODULE").'</label></span>';
}

$tpl = cSmartyFrontend::getInstance();
$tpl->assign('truncate', $truncate);
$tpl->assign('uuid', $uuid);
$tpl->assign('text', $text);
$tpl->assign('more', mi18n("MORE"));
$tpl->assign('less', mi18n("LESS"));
$tpl->display('default.html');

if (!$editmode && $truncate){
?>
<script>
$(document).ready(function() {
  $('#truncate-<?= $uuid ?>').trunk8({
     lines: <?= $lines ?>,
     parseHTML: true,
     tooltip: false,
     fill: '&hellip;'
  });
  <?php if(!$own_js){ ?>
  $('.read-more').click(function(){
    $('#truncate-'+$(this).attr('target')).trunk8('revert');
    $(this).hide();
    $('.read-less[target='+$(this).attr('target')+']').show();
  });

  $('.read-less').click(function(){
      $('#truncate-'+$(this).attr('target')).trunk8();
      $(this).hide();
      $('.read-more[target='+$(this).attr('target')+']').show();
  });
  <?php } ?>
});
</script>
<?php } ?>
