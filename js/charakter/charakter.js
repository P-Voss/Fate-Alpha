jQuery(document).ready(function () {
    
    indicators();
    
    function indicators(){
        indicators = jQuery(".indicator");
        for (i = 0; i < indicators.length; i++){
            element = indicators[i];
            jQuery(element).text(
                jQuery(element)
                    .parent()
                    .parent()
                    .children(".subContent")
                    .get(0)
                    .scrollHeight  > 0 ? "+" : ""
            );
        }
    }
    
    jQuery("legend").on('click', function(){
        element = jQuery(this).parent().children(".subContent");
        if(element.length !== 0){
            indicator = jQuery(this).children(".indicator");
            if(element.height() > 0){
                element.animate({height: 0}, {duration: 400, queue: false});
            }else{
                element.animate({height: element.get(0).scrollHeight}, {duration: 400, queue: false});
            }

            if(element.get(0).scrollHeight > 0){
                indicator.text(element.height() === element.get(0).scrollHeight ? "+" : "-");
            }
        }
    });
    
});