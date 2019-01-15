<?php
/**
 * Created by PhpStorm.
 * User: manish
 * Date: 11/1/19
 * Time: 3:41 PM
 */

namespace Codilar\ProductListing\Block;

class Link extends \Magento\Framework\View\Element\Html\Link
{
    /**
     * Render block HTML.
     *
     * @return string
     */
    protected function _toHtml()
    {
        if (false != $this->getTemplate()) {
            return parent::_toHtml();
        }
        return '<li><a ' . $this->getLinkAttributes() . ' >' . $this->escapeHtml($this->getLabel()) . '</a></li>';
    }
}