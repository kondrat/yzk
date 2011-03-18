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
    
     $file4_cltClientBannerWrp.delegate(".cmp-edit","click",function(){
         
        $this = $(this);
        $thisParent = $this.parents(".cmp-client");
        
        $file4_cltClientBannerWrp.find(".cmp-modes").hide().end().find(".cmp-client").removeClass("cmp-clientActive");
        $thisParent.addClass("cmp-clientActive");
        
        $thisParent.find(".cmp-modes").toggle();
        
    })


   var f_file4_savePhraseMode = function(here){
           
          
           
           
        $.ajax({
            dataType:"json",
            url: path+"\/phrases\/savePhrMode",
            type: "POST",
            data: here,
            success:function (data, textStatus) {
                if( data.data) {
                    alert('success'); 

                         


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



      $file4_cltClientBannerWrp.delegate(".cmp-save","click",function(){
         
        var $this = $(this);
        var $thisParent = $this.parents(".cmp-client");
        
        var mode = $thisParent.find("select").val();
        
        var modeX = $thisParent.find(".cmp-xinput").val();
        
        var tmplItem = $thisParent.tmplItem();
        
        var campId = tmplItem.data.CampaignID;
        var banId = tmplItem.data.BannerID;
        var phrId = tmplItem.data.PhraseID;
        
        var modeData = {"data[mode]":mode,"data[modeX]":modeX,"data[campId]":campId,"data[banId]":banId,"data[phrId]":phrId};

        
        
        f_file4_savePhraseMode(modeData);
        
    })
});