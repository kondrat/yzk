/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
jQuery(document).ready(function(){
    var $file1_cltClientListWrp = $("#clt-clientListWrp");
    
    
    var f_file1_getClientsList = function(){
 
                $.ajax({
                    dataType:"json",
                    url: "\/clients\/getYnClData",s
                    type: "POST",
                    data: {
                        "data[method]":'GetClientsList'
                        
                    },
                    success:function (data, textStatus) {
                        if( data.data) {
                          //alert('success'); 

                          //$("#clt-clientListTmpl").tmpl(data.data).appendTo($file1_cltClientListWrp);
                         


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
 
 
});