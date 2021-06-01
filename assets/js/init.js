jQuery('.mobile-menu-container li.menu-item-has-children').each(function(){
    var parentLi = jQuery(this);
    var dropdownUl = parentLi.find('ul.aws-sub-menu').first();
    
    parentLi.find('.fa').first().on('click', function(){
        //set height is auto for all parents dropdown
        parentLi.parents('li.menu-item-has-children').css('height', 'auto');
        //set height is auto for menu wrapper
        mobileMenuWrapper.css({'height': 'auto'});
        
        var dropdownUlheight = dropdownUl.outerHeight() + 40;
        
        if(parentLi.hasClass('opensubmenu')) {
            parentLi.removeClass('opensubmenu');
            parentLi.animate({'height': 40}, 'fast', function(){
                //calculate new height of menu wrapper
                mobileMenuH = mobileMenuWrapper.outerHeight();
            });
            parentLi.find('.fa').first().removeClass('fa-angle-down');
            parentLi.find('.fa').first().addClass(' fa-angle-right');
        } else {
            parentLi.addClass('opensubmenu');
            parentLi.animate({'height': dropdownUlheight}, 'fast', function(){
                //calculate new height of menu wrapper
                mobileMenuH = mobileMenuWrapper.outerHeight();
            });
            parentLi.find('.fa').first().addClass('fa-angle-down');
            parentLi.find('.fa').first().removeClass(' fa-angle-right');
        }
        
    });
});