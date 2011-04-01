/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
jQuery(document).ready(function(){
    
    var $file2_campResWrp = $("#cmp-campResWrp");
 
    var $file2_cmpLoaderWrp = $("#cmp-loaderWrp");
 
 
 
    
    var f_file2_getClientsCampList = function(){
                
        $.ajax({
            dataType:"json",
            url: path+"\/campaigns\/getYnCampList",
            type: "POST",
            data: {
                "data[clname]":$file2_campResWrp.data("clname")
            },
            success:function (data, textStatus) {
                if( data.data) {
                    
                    $file2_cmpLoaderWrp.hide();                   
                    $("#cmp-clientCompListHdTmpl").tmpl(data).appendTo($file2_campResWrp);
                         


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
 
    //srart of the campings content
    f_file2_getClientsCampList();









    var f_file2_getClientsCampInfo = function(campid){
                
        $.ajax({
            dataType:"json",
            url: path+"\/campaigns\/getYnCampInfo",
            type: "POST",
            data: {
                
                "data[campid]":campid
            },
            success:function (data, textStatus) {
                if( data.data) {
                    
                    $file2_cmpLoaderWrp.hide(); 
                    
                    $file2_campResWrp.empty();
                    
                    $("#cmp-clientCompInfoHdTmpl").tmpl(data).appendTo($file2_campResWrp);
                         


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




    $file2_campResWrp.delegate(".cmp-campLnk","click",function(event){
               
        event.preventDefault();
        
        var $thisParent = $(this).parents(".cmp-client");
        
        var $thisDataItem = $thisParent.tmplItem();
        
        console.log($thisDataItem);
        
        $file2_cmpLoaderWrp.show();
               
        f_file2_getClientsCampInfo($thisDataItem.data.CampaignID);

        
    })







    $file2_campResWrp.delegate(".cmp-client","mouseenter",function(){
        $(this).addClass("clt-clientHgl");
    })
    $file2_campResWrp.delegate(".cmp-client","mouseleave",function(){
        $(this).removeClass("clt-clientHgl");
    })
 
 
});