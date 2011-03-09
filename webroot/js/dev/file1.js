/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
jQuery(document).ready(function(){
    var $file1_cltClientListWrp = $("#clt-clientListWrp");
    
    
    var f_file1_getClientsList = function(){
                
        $.ajax({
            dataType:"json",
            url: path+"\/clients\/getYnClData",
            type: "POST",
            data: {
                "data[method]":'GetClientsList'
                        
            },
            success:function (data, textStatus) {
                if( data.data) {
                    //alert('success'); 
                    $file1_cltClientListWrp.empty();
                    $("#clt-clientListTmpl").tmpl(data.data).appendTo($file1_cltClientListWrp);
                         


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
 
    f_file1_getClientsList();
    
    $file1_cltClientListWrp.delegate(".clt-client","mouseenter",function(){
        $(this).addClass("clt-clientHgl");
    })
    $file1_cltClientListWrp.delegate(".clt-client","mouseleave",function(){
        $(this).removeClass("clt-clientHgl");
    })
    $file1_cltClientListWrp.delegate(".clt-newCltReg","click",function(event){
        event.preventDefault();
        //@todo replace with plugin play
        $file1_cltClientListWrp.find(".clt-cltRegWrp").remove().end().find(".clt-clientAct").removeClass("clt-clientAct");
        var $thisWrp = $(this).parent(".clt-client");
        $thisWrp.addClass('clt-clientAct');      
        $("#clt-clientRegtTmpl").tmpl().appendTo($thisWrp);
    })
    
    $file1_cltClientListWrp.delegate("#clt-cltRegBtn","click",function(){
        var $this = $(this);
        var $thisWrp = $this.parents(".clt-client");
        var tmplItem = $.tmplItem( $thisWrp );
        var userYnLogin = tmplItem.data.Login;
        var thisEmail = $("#ClientEmail").val();
        
        $.ajax({
            dataType:"json",
            url: path+"\/clients\/regYnCl",
            type: "POST",
            data: {
                "data[ynLogin]":userYnLogin,
                "data[email]":thisEmail                      
            },
            success:function (data, textStatus) {
                if( data.data) {
                    //alert('success'); 
                    //@todo to add smth for work after success
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
        
        
        
        
    });
 
 
});