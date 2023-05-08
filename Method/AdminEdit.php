<?php
namespace GDO\Tags\Method;

use GDO\Core\GDT;
use GDO\DB\Database;
use GDO\Form\GDT_AntiCSRF;
use GDO\Form\GDT_Form;
use GDO\Form\GDT_Submit;
use GDO\Form\GDT_Validator;
use GDO\Form\MethodForm;
use GDO\Tags\GDO_Tag;
use GDO\Tags\GDT_Tag;
use GDO\Tags\Module_Tags;
use GDO\Util\Common;

final class AdminEdit extends MethodForm
{

	private $gdo;

	public function execute(): GDT
	{
		$this->gdo = GDO_Tag::table()->find(Common::getRequestString('id'));
		return Module_Tags::instance()->renderAdminTabs()->addField(parent::execute());
	}

	protected function createForm(GDT_Form $form): void
	{
		$tags = GDO_Tag::table();
		$form->addFields(...$tags->gdoColumnsCache());
		$form->addField(GDT_AntiCSRF::make());
		$form->actions()->addField(GDT_Submit::make());
		$form->actions()->addField(GDT_Submit::make('delete'));
		$form->actions()->addField(GDT_Submit::make('merge'));
		$form->addField(GDT_Tag::make('merge_tag'));
		$form->addField(GDT_Validator::make()->validatorFor($form, 'merge_tag', [$this, 'validateMergeTarget']));
// 		$form->withGDOValuesFrom($this->gdo);
	}

	public function formValidated(GDT_Form $form): GDT
	{
		$this->gdo->saveVars($form->getFormVars());
		return parent::formValidated($form);
	}

	public function validateMergeTarget(GDT_Form $form, GDT_Tag $tag)
	{
		if (isset($_REQUEST['merge']))
		{
			if (!($other = $tag->getValue()))
			{
				return $tag->error('err_tag_merge_target_needed');
			}
			if ($other->getID() === $this->gdo->getID())
			{
				return $tag->error('err_tag_merge_target_self');
			}
		}
		return true;
	}

	public function onSubmit_merge(GDT_Form $form)
	{
// 		$mergeInto = $form->getField('merge_tag')->getValue();

// 		foreach (TagTable::allTagTables() as $tagTable)
// 		{
// 			foreach ($tagTable->allObjectsWithTag($this->gdo) as $object)
// 			{
// 				$tagTable
// 			}
// 		}
	}

	public function onSubmit_delete(GDT_Form $form)
	{
		$this->gdo->delete();
		$rows = Database::instance()->affectedRows();
		$this->redirectMessage('msg_tag_deleted', [$rows])->href(href('Tags', 'AdminOverview'));
	}

}
