<?php  
defined('C5_EXECUTE') or die("Access Denied.");
$al = Loader::helper('concrete/asset_library');
$bf = null;
$bfo = null;

if ($controller->getFileID() > 0) { 
	$bf = $controller->getFileObject();
}
if ($controller->getFileOnstateID() > 0) { 
	$bfo = $controller->getFileOnstateObject();

}
?>

<fieldset>
<?php
$args = array();
if ($forceImageToMatchDimensions && $maxWidth && $maxHeight) {
	$args['maxWidth'] = $maxWidth;
	$args['maxHeight'] = $maxHeight;
	$args['minWidth'] = $maxWidth;
	$args['minHeight'] = $maxHeight;
}
?>

<div class="form-group">
	<label class="control-label"><?php echo t('Image')?></label>
	<?php echo $al->image('ccm-b-image', 'fID', t('Choose Image'), $bf, $args);?>
</div>
<div class="form-group">
	<label class="control-label"><?php echo t('Image Hover')?> <small style="color:#999999; font-weight: 200;"><?php echo t('(Optional)'); ?></small></label>
	<?php echo $al->image('ccm-b-image-onstate', 'fOnstateID', t('Choose Image On-State'), $bfo, $args);?>
</div>

</fieldset>
<hr/>

<fieldset>

<div class="form-group">
	<?php echo $form->label('linkType', t('Image Link'))?>
	<select name="linkType" id="linkType" class="form-control" style="width: 60%;">
		<option value="0" <?php echo (empty($externalLink) && empty($internalLinkCID) ? 'selected="selected"' : '')?>><?php echo t('None')?></option>
		<option value="1" <?php echo (empty($externalLink) && !empty($internalLinkCID) ? 'selected="selected"' : '')?>><?php echo t('Another Page')?></option>
		<option value="2" <?php echo (!empty($externalLink) ? 'selected="selected"' : '')?>><?php echo t('External URL')?></option>
	</select>
</div>

<div id="linkTypePage" style="display: none;" class="form-group">
	<?php echo $form->label('internalLinkCID', t('Choose Page:'))?>
	<?php echo Loader::helper('form/page_selector')->selectPage('internalLinkCID', $internalLinkCID); ?>
</div>

<div id="linkTypeExternal" style="display: none;" class="form-group">
	<?php echo $form->label('externalLink', t('URL'))?>
	<?php echo $form->text('externalLink', $externalLink, array('style'=>'width: 60%;')); ?>
</div>


<div class="form-group">
	<?php echo $form->label('altText', t('Alt. Text'))?>
	<?php echo $form->text('altText', $altText, array('style'=>'width: 60%;')); ?>
</div>

<div class="form-group">
    <?php echo $form->label('title', t('Title'))?>
    <?php echo $form->text('title', $title, array('style'=>'width: 60%;')); ?>
</div>

</fieldset>

<fieldset>
<hr/>

	<?php if ($maxWidth == 0) { 
		$maxWidth = '';
	} 
	if ($maxHeight == 0) {
		$maxHeight = '';
	}
	?>

<label><?php echo t('Constrain Image Size'); ?></label>
<div class="form-group">
	<?php echo $form->label('maxWidth', t('Max Width'))?>
	<?php echo $form->text('maxWidth', $maxWidth, array('style' => 'width: 60px')); ?>
</div>

<div class="form-group">
	<?php echo $form->label('maxHeight', t('Max Height'))?>
	<?php echo $form->text('maxHeight', $maxHeight, array('style' => 'width: 60px')); ?>
</div>

<div class="form-group">
	<?php echo $form->label('forceImageToMatchDimensions', t('Scale Image'))?>
	<select name="forceImageToMatchDimensions" class="form-control" id="forceImageToMatchDimensions">
		<option value="0" <?php if (!$forceImageToMatchDimensions) { ?> selected="selected" <?php } ?>><?php echo t('Automatically')?></option>
		<option value="1" <?php if ($forceImageToMatchDimensions == 1) { ?> selected="selected" <?php } ?>><?php echo t('Force Exact Image Match')?></option>
	</select>
</div>

</fieldset>