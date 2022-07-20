<?php /** @var $field \GDO\Tag\GDT_Tags **/ ?>
<div class="gdt-container<?= $field->classError(); ?>">
  <?= $field->htmlIcon(); ?>
  <label <?=$field->htmlForID()?>><?= $field->displayLabel(); ?></label>
  <div>
<?php $comma = ''; ?>
<?php foreach ($field->tagtable->allObjectTags() as $tagObj) : ?>
  <?php printf('%s%s(%d)', $comma, $tagObj->gdoDisplay('tag_name'), $tagObj->gdoVar('tag_count')); ?>
  <?php if (!$comma) $comma = ', '; ?>
<?php endforeach; ?>
  </div>
  <input
   <?=$field->htmlID()?>
   type="text"
   <?=$field->htmlFormName()?>
   size="64"
   <?= $field->htmlDisabled(); ?>
   <?= $field->htmlRequired(); ?>
   value="<?= $field->renderVar(); ?>" />
  <?= $field->htmlError(); ?>
</div>
