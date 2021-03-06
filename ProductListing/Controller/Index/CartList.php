<?php
/**
 * Created by PhpStorm.
 * User: manish
 * Date: 13/1/19
 * Time: 8:03 PM
 */

namespace Codilar\ProductListing\Controller\Index;

use Magento\Catalog\Model\CategoryFactory;
use Magento\Catalog\Model\CategoryRepository;
use Magento\Catalog\Model\ResourceModel\Category\CollectionFactory;
use Magento\Catalog\Ui\DataProvider\Product\ProductCollectionFactory;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Request\Http;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;

class CartList extends Action
{
    protected $pageFactory;
    protected $collectionFactory;
    protected $request;
    protected $layer;
    public $registry;
    public $categoryFactory;
    /**
     * @var
     */
    private $productCollectionFactory;
    /**
     * @var
     */
    private $categoryRepository;
    /**
     * @var
     */
    private $resultJsonFactory;
    public $resultPageFactory;

    public function __construct(
        Context $context,
        CollectionFactory $collectionFactory,
        Http $request,
        ProductCollectionFactory $productCollectionFactory,
        Registry $registry,
        PageFactory $resultPageFactory,
        JsonFactory $resultJsonFactory,
        CategoryRepository $categoryRepository,
        CategoryFactory $categoryFactory,
        PageFactory $pageFactory
    ) {
        $this->pageFactory = $pageFactory;
        $this->collectionFactory=$collectionFactory;
        $this->request=$request;
        $this->resultPageFactory = $resultPageFactory;
        $this->registry=$registry;
        $this->productCollectionFactory = $productCollectionFactory;
        $this->categoryFactory=$categoryFactory;
        $this->categoryRepository = $categoryRepository;
        $this->resultJsonFactory = $resultJsonFactory;
        return parent::__construct($context);
    }

    public function getMainSelectCategoryParam()
    {
        $categoryTitle=$this->request->getParam('maincategory');
        var_dump($categoryTitle);
        return $categoryTitle;
    }

    public function getCurrentCategoryId($categoryName)
    {
        if ($categoryName !=null) {
            $collection = $this->collectionFactory->create()->addFieldToSelect('entity_id')
                ->addFieldToFilter('name', $categoryName);
            return $collection->getFirstItem()->getData('entity_id');
        } else {
            return null;
        }
    }

    public function setCustomVariable()
    {
        $this->registry->register('look_category', $this->getCurrentCategoryId($this->getMainSelectCategoryParam()));
    }

    public function getProductByCategoryId($categoryId)
    {
        $category = $this->categoryFactory->create()->load($categoryId)->getProductCollection()->addAttributeToSelect('*');
        foreach ($category as $product) {
            $productName[] = $product->getData('name');
        }
        if (isset($productName)) {
            return $productName;
        }
    }

    public function getAjaxData()
    {
        return $this->getRequest()->getParam('isAjax');
    }

    public function execute()
    {
        $result = $this->resultJsonFactory->create();
        $resultPage = $this->resultPageFactory->create();
        //$this->getCurrentCategoryId($this->getMainSelectCategoryParam());
        //var_dump($this->setCustomVariable());
        // $mainCategoryId=$this->getCurrentCategoryId($this->getMainSelectCategoryParam());
        $prodId=$this->getRequest()->getParam("product_id");
        $catId=$this->getRequest()->getParam("subcat");
        $catName=$this->getRequest()->getParam("catName");
        $block = $resultPage->getLayout()
            ->createBlock(\Codilar\ProductListing\Block\Cart::class)
            ->setTemplate('Codilar_ProductListing::cart.phtml')
            ->setProductId($prodId)
            ->setSubId($catId)
            ->setCatName($catName)
            ->toHtml();

        $result->setData(['output' => $block]);
        return $result;
    }
}
