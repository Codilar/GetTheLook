require([
    'jquery',
], function ($) {
    'use strict';

var status;
    $(document).on("click", ".img", function(){
        const catId=this.dataset.img;
        const prodId=this.dataset.productid;
        const catName=this.dataset.catname;
         status=0;
         var prevId;
        $("#selected .img[data-catname]").each(function () {
            console.log(this);
            var checkCatName=this.dataset.catname;
            prevId=this.id;
            console.log(prevId);
            console.log(checkCatName);
            if(checkCatName == catName)
            {
                status=1;
                return false;
            }
        });
        console.log(status);
        ajaxCall(prodId,catId,catName,prevId);
    });

    
    $('button').click(function () {
        let list= [];
       $("#selected .img[data-catname]").each(function () {

            list.push(this.dataset.prodid);
       })
        addToCartAjax(list);
    });

    function ajaxCall(prodId,catId,catName,prevId)
    {
        let linkUrl = window.BASE_URL+'customised/index/cartlist';
        $.ajax({
            url:linkUrl,
            data:{'product_id': prodId,'subcat':catId,'catName':catName},
            traditional: true,
            showLoader: true,
            success: function (response) {
                let newdiv = "<div id=" + prodId + "-img class=img data-catName=" + catName +" data-prodId="+prodId +">" + response.output + "</div>";
                if (status == 1) {
                    var divTarget =".sidebar-additional #selected "+"#"+prevId;
                    console.log(divTarget);
                    $(divTarget).replaceWith(newdiv);
                }
                else{
                    $('.sidebar-additional #selected').append(newdiv);
                }
                $('#button').css("display","block");
            },
            error: function failCallBk(XMLHttpRequest, textStatus, errorThrown) {
                alert("An error occurred while processing your request. Please try again.");
            }
        });
    }

    function addToCartAjax(productList) {
console.log(productList);
        let linkUrl = window.BASE_URL+'customised/index/addtocart';
        $.ajax({
            url:linkUrl,
            data:{'product_list': productList},
            traditional: true,
            showLoader: true,
            success: function (response) {
                console.log(response);
            },
            error: function failCallBk(XMLHttpRequest, textStatus, errorThrown) {
                alert("An error occurred while processing your request. Please try again.");
            }
        });
    }
   
});