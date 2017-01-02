/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
jQuery(document).ready(function () {
    
    function klappen(ID) {
        if (ID === 'Klicken') {
            $("#Vorraussetzungen").animate({"height": "toggle"}, {duration: 1000});
        }
    }
    
    jQuery("#str").click(function(){
        jQuery("#staerke").removeAttr('disabled');
    });
    jQuery("#agi").click(function(){
        jQuery("#agilitaet").removeAttr('disabled');
    });
    jQuery("#aus").click(function(){
        jQuery("#ausdauer").removeAttr('disabled');
    });
    jQuery("#kon").click(function(){
        jQuery("#kontrolle").removeAttr('disabled');
    });
    jQuery("#dis").click(function(){
        jQuery("#disziplin").removeAttr('disabled');
    });
    jQuery("#pra").click(function(){
        jQuery("#uebung").removeAttr('disabled');
    });
    
});
