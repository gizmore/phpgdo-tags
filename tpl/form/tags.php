<?php
namespace GDO\Tags\tpl\form;

use GDO\Tags\GDT_Tags;

/** @var $field GDT_Tags * */
?>
<div class="gdt-container<?=$field->classError()?>">
    <label<?=$field->htmlForID()?>><?=$field->htmlIcon()?><?=$field->renderLabel()?></label>
    <div>
		<?php
		$comma = ''; ?>
		<?php
		foreach ($field->tagtable->allObjectTags() as $tagObj) : ?>
			<?php
			printf('%s%s(%d)', $comma, $tagObj->gdoDisplay('tag_name'), $tagObj->gdoVar('tag_count')); ?>
			<?php
			if (!$comma)
			{
				$comma = ', ';
			} ?>
		<?php
		endforeach; ?>
    </div>
    <input
		<?=$field->htmlID()?>
            type="text"
		<?=$field->htmlName()?>
            size="64"
		<?=$field->htmlDisabled()?>
		<?=$field->htmlRequired()?>
            value="<?=html($field->getVar())?>"/>
	<?=$field->htmlError()?>
</div>
