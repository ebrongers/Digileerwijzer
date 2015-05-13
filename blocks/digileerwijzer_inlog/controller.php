<?php 
namespace Concrete\Package\Digileerwijzer\Block\DigileerwijzerInlog;
use \Concrete\Core\Block\BlockController;
use Loader;
use \File;
use FileSet;
use FileList;
use BlockType;
use Page;
use Core;
use \Concrete\Package\Digileerwijzer\Models\DglwModel;
use \Concrete\Core\Block\View\BlockView as BlockView;
use Concrete\Core\File\Type\Type as FileType;



class Controller extends BlockController
{

	protected $btInterfaceWidth = 530;
	protected $btInterfaceHeight = 450;
	protected $btTable = 'btDigileerwijzerLogin';
	protected $btWrapperClass = 'ccm-ui';

	/**
	 * Used for localization. If we want to localize the name/description we have to include this
	 */
	public function getBlockTypeDescription()
	{
		return t("Displays register page for digileerwijzer.");
	}

	public function getBlockTypeName()
	{
		return t("Register block digileerwijzer");
	}

	public function getJavaScriptStrings()
	{
		return array('fileset-required' => t('You must select a file set.'));
	}
	
	public function add() {
	
	}

	public function validate($args)
	{


	}
	public function registerViewAssets()
	{
		$uh = Loader::helper('concrete/urls');
		
		$bObj = $this->getBlockObject();
		if($bObj){
			$bt=$bObj->getBlockTypeObject();
			$blockURL = $uh->getBlockTypeAssetsURL($bt);
				
			$this->requireAsset('javascript', 'jquery');
			$this->addFooterItem('<script type="text/javascript" src="'.$blockURL.'/assets/dglw_inlog.js"></script>');
			
		}
	}

	function save($args)
	{

		$args['numberFiles'] = ($args['numberFiles'] > 0) ? $args['numberFiles'] : 0;
		$args['displaySetTitle'] = ($args['displaySetTitle']) ? '1' : '0';
		$args['replaceUnderscores'] = ($args['replaceUnderscores']) ? '1' : '0';
		$args['displaySize'] = ($args['displaySize']) ? '1' : '0';
		$args['displayDateAdded'] = ($args['displayDateAdded']) ? '1' : '0';
		$args['uppercaseFirst'] = ($args['uppercaseFirst']) ? '1' : '0';
		$args['paginate'] = ($args['paginate']) ? '1' : '0';

		parent::save($args);
	}


	public function getFileSetID()
	{
		return $this->fsID;
	}

	public function getFileSetName()
	{
		if ($this->fileSetName)
			return $this->fileSetName;
		else {
			$fs = FileSet::getById($this->fsID);
			return $fs->getFileSetName();
		}

	}

	public function view() {
		
		$scholen= array(0=>"Selecteer een school...");
		
		$scholen=$scholen+DglwModel::getScholen(1);
		$this->set('scholen',$scholen);
		$this->set('secties',DglwModel::getSecties());
	}


	public function getFileSet()
	{

		$fs = FileSet::getById($this->fsID);

		$files = array();

		// if the file set exists (may have been deleted)
		if ($fs->fsID) {

			$this->fileSetName = $fs->getFileSetName();

			$fl = new FileList();
			$fl->filterBySet($fs);

			if ($this->fileOrder == 'date_asc')
				$fl->sortBy('fDateAdded', 'asc');
			elseif ($this->fileOrder == 'date_desc')
			$fl->sortBy('fDateAdded', 'desc');
			elseif ($this->fileOrder == 'alpha_asc')
			$fl->sortBy('fvTitle', 'asc');
			elseif ($this->fileOrder == 'alpha_desc')
			$fl->sortBy('fvTitle', 'desc');
			elseif ($this->fileOrder == 'set_order')
			$fl->sortBy('fsDisplayOrder', 'asc');
			elseif ($this->fileOrder == 'set_order_rev')
			$fl->sortBy('fsDisplayOrder', 'desc');

			if ($this->numberFiles > 0){
				$fl->setItemsPerPage($this->numberFiles);
			} else {
				$fl->setItemsPerPage(10000);
			}


			$pagination = $fl->getPagination();
			$files = $pagination->getCurrentPageResults();
			if ($pagination->getTotalPages() > 1) {

				if ($this->paginate) {
					$pagination = $pagination->renderDefaultView();
					$this->set('pagination', $pagination);
				}

			}


		}

		return $files;
	}


	public function getSearchableContent()
	{
		$files = $this->getFileSet();
		$search = '';
		foreach ($files as $f) {
			$fv = $f->getApprovedVersion();
			$filename = $fv->getFileName();
			$title = $f->getTitle();
			$description = $f->getDescription();
			$tags = $f->getTags();
			$search .= $title . ' ' . $filename . ' ' . $description . ' ' . $tags . '<br/>';
		}
		return $this->getFileSetName() . ' ' . $search;
	}


}

?>