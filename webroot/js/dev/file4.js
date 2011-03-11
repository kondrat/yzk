/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
jQuery(document).ready(function(){
    var $file4_cltClientBannerWrp = $("#cmp-clientBannerWrp");
    
    
    var f_file4_getClientsCampInfo = function(){
                
        $.ajax({
            dataType:"json",
            url: path+"\/campaigns\/getYnBanInfo",
            type: "POST",
            data: {
                "data[method]":'GetBannerPhrases',
                "data[bannid]":$('#cmp-clientBannerWrp').data("bannid")
            },
            success:function (data, textStatus) {
                if( data.data) {
                    //alert('success'); 
                    $file4_cltClientBannerWrp.empty();
                    $("#cmp-clientBannerTmpl").tmpl(data.data).appendTo($file4_cltClientBannerWrp);
                         


                } else if(data.error){
                    alert("Error here: "+data.error);
                } else if(data.error_code){
                    alert(data.error_code+' | '+data.error_detail+' | '+data.error_str);
                } else {
                    //flash_message("Couldn't be deleted", "fler" );
                    alert('No Data')
                }
            },
                    
            error:function(){
                alert('Problem with the server. Try again later.');
            }
        }); 

    };
 
    f_file4_getClientsCampInfo();
    
    $file4_cltClientBannerWrp.delegate(".cmp-client","mouseenter",function(){
        $(this).addClass("clt-clientHgl");
    })
    $file4_cltClientBannerWrp.delegate(".cmp-client","mouseleave",function(){
        $(this).removeClass("clt-clientHgl");
    })
 
 
});