<?php
namespace GDO\Tag;

use GDO\Core\GDO_Module;
use GDO\Angular\Module_Angular;
use GDO\Core\Application;

/**
 * Module to ease tagging of GDOs.
 * 
 * @author gizmore
 * @version 6.10.1
 * @since 6.4.0
 * 
 * @see WithTags
 * @see GDT_Tags
 * @see GDO_Tag
 * @see GDO_TagTable
 */
final class Module_Tag extends GDO_Module
{
	public int $priority = 40;
	
	public function onLoadLanguage() : void { $this->loadLanguage('lang/tags'); }
	
	public function getClasses() : array { return [GDO_Tag::class]; }
	
	public function onIncludeScripts() : void
	{
	    if (module_enabled('Angular'))
	    {
	        if (Module_Angular::instance()->cfgIncludeScripts() ||
	            Application::instance()->hasTheme('material'))
	        {
    	        $this->addJS('js/gwf-tag-ctrl.js');
	        }
	    }
	}
	
	public function href_administrate_module() { return href('Tag', 'AdminOverview'); }
	
	public function renderAdminTabs()
	{
		return $this->php('admin_tabs.php');
	}

	#############
	### Hooks ###
	#############
	public function hookClearCache()
	{
// 		$query = Tag::table()->update()->set("tag_count=COUNT(*)")->where('true')->group('tag_id');
// 		foreach (Application::instance()->getModules() as $module)
// 		{
// 			if ($classes = $module->getClasses())
// 			{
// 				foreach ($classes as $class)
// 				{
// 					if (is_subclass_of($class, 'GDO\Tag\GDO_TagTable'))
// 					{
// 						$table = GDO::tableFor($class);
// 						$query->join("RIGHT JOIN {$table->gdoTableIdentifier()} ON tag_tag=tag_id");
// 					}
// 				}
// 			}
// 		}
// 		$query->exec();
// 		Tag::table()->deleteWhere('tag_count=0')->exec();
	}
	
	##################
	### Top Navbar ###
	##################
	public function tagsNavbar()
	{
		return $this->templatePHP('navbar.php');
	}

}
