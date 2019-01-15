require([
    'jquery',
], function ($) {
    'use strict';
    function changeUrl() {
        const appendSubCategory = this.dataset.href;
        const subCatId= this.dataset.id;
        console.log(subCatId);
        let ajaxUrl = window.location.href.replace(/\/?$/, '/');
        let newUrl = window.location.href.replace(/\/?$/, '/');
        console.log(document.location.href.indexOf(subCatId));
        if(document.location.href.indexOf(appendSubCategory)  === -1){
        if (document.location.href.indexOf('?') !== -1) {
            newUrl = document.location.href + "&" + subCatId;
            ajaxUrl = getPathFromUrl(document.location.href) + "?subcat=" + subCatId;
            window.history.pushState(null, null,  newUrl);
            ajaxCall(subCatId,appendSubCategory);
        } else {
             newUrl = document.location.href + "?subcat=" + subCatId;
            ajaxUrl = getPathFromUrl(document.location.href) + "?subcat=" + subCatId;
            window.history.pushState(null, null,  newUrl);
            ajaxCall( subCatId,appendSubCategory);
        }
        //window.history.pushState(null, null,  newUrl);
    }else{
            let block= '#'+appendSubCategory+"-block";
            $(block).css('display',"none");
        }
    }
        function getPathFromUrl(url) {
            console.log(url.split("?")[0]);
            return url.split("?")[0];
        }
    const subcategory=document.querySelectorAll(".subcategory-button");
    subcategory.forEach(button => {
        return button.addEventListener('click', changeUrl);
    });

    function ajaxCall(subcatId,appendSubCategory)
    {

        console.log(window.BASE_URL);
        let linkUrl = window.BASE_URL+'customised/index/productcolumn';
        console.log(linkUrl+"?subcat="+subcatId );
        let url=linkUrl+"?subcat="+subcatId;
        $.ajax({
            url:url,
            data:{'subcatName': appendSubCategory},
            traditional: true,
            showLoader: true,
            success: function (response) {
                //let newdiv = "<div id="+appendSubCategory+"-block>"+response.output+"</div>";
                let block="#"+appendSubCategory+"-block";
                $(block).append(response.output);
            },
            error: function failCallBk(XMLHttpRequest, textStatus, errorThrown) {
                alert("An error occurred while processing your request. Please try again.");
            }
        });
    }
});