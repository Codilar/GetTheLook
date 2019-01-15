<?php
/**
 * Created by PhpStorm.
 * User: manish
 * Date: 12/1/19
 * Time: 10:55 AM
 */

namespace Codilar\ProductListing\Block;

use Magento\Catalog\Helper\Category;
use Magento\Catalog\Model\ResourceModel\Category\CollectionFactory;
use Magento\Framework\View\Element\Template;

class CategoryLook extends Template
{
    /**
     * @var Category
     */
    public $categoryHelper;
    protected $_categoryCollectionFactory;
    protected $_categoryHelper;

    /**
     * CategoryLook constructor.
     * @param Template\Context $context
     * @param CollectionFactory $categoryCollectionFactory
     * @param Category $categoryHelper
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        CollectionFactory $categoryCollectionFactory,
        Category $categoryHelper,
        array $data = []
    ) {
        $this->_categoryCollectionFactory = $categoryCollectionFactory;
        $this->_categoryHelper = $categoryHelper;
        parent::__construct($context, $data);
    }

    public function getCategoryCollection($isActive = true, $level = false, $sortBy = false, $pageSize = false)
    {
        $collection = $this->_categoryCollectionFactory->create();
        $collection->addAttributeToSelect('*');

        // select only active categories
        if ($isActive) {
            $collection->addIsActiveFilter();
        }

        // select categories of certain level
        if ($level) {
            $collection->addLevelFilter($level);
        }

        // sort categories by some value
        if ($sortBy) {
            $collection->addOrderField($sortBy);
        }

        // select certain number of categories
        if ($pageSize) {
            $collection->setPageSize($pageSize);
        }

        return $collection;
    }

    public function getStoreCategories($sorted = false, $asCollection = false, $toLoad = true)
    {
        return $this->_categoryHelper->getStoreCategories($sorted = false, $asCollection = false, $toLoad = true);
    }
}
