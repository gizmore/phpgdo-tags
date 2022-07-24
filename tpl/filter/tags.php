<?php /** @var $field \GDO\Tags\GDT_Tags **/ ?>
<input
 name="f[<?=$field->name?>]"
 type="text"
 size="16>"
 value="<?=html($field->filterVar())?>"
 placeholder="<?=t('tag_filter')?>" />
