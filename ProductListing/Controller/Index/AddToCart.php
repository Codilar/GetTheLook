<?php
/**
 * Created by PhpStorm.
 * User: manish
 * Date: 13/1/19
 * Time: 8:03 PM
 */

namespace Codilar\ProductListing\Controller\Index;

use Magento\Catalog\Model\ProductRepository;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Request\Http;
use Magento\Framework\View\Result\PageFactory;

class AddToCart extends Action
{
    protected $formKey;
    protected $cart;
    protected $product;
    /**
     * @var ProductRepository
     */
    private $productRepository;
    /**
     * @var Http
     */
    private $request;
    /**
     * @var PageFactory
     */
    private $resultPageFactory;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\Data\Form\FormKey $formKey,
        \Magento\Checkout\Model\Cart $cart,
        \Magento\Catalog\Model\Product $product,
        PageFactory $resultPageFactory,
        Http $request,
        ProductRepository $productRepository,
        array $data = []
    ) {
        $this->formKey = $formKey;
        $this->cart = $cart;
        $this->product = $product;
        $this->productRepository = $productRepository;
        $this->request = $request;
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();

        $productList=$this->request->getParam('product_list');
        var_dump($productList);
//        foreach ($productList as $sku) {
        $product = $this->productRepository->get($productList);
        $params = [
            'form_key' => $this->formKey->getFormKey(),
            'product' => $product->getId(), //product Id
            'qty'   =>1, //quantity of product
        ];
        $this->_redirect("checkout/cart/add/form_key/", $params);

        /** @var \Magento\Framework\View\Result\Page $resultPage */
        return $resultPage;
    }
}
