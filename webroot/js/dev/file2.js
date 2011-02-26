/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
jQuery(document).ready(function(){
    var $file2_cltClientCampListWrp = $("#clt-clientCampListWrp");
    
    
    var f_file1_getClientsCampList = function(){
                
                $.ajax({
                    dataType:"json",
                    url: path+"\/campaigns\/getYnCampList",
                    type: "POST",
                    data: {
                        "data[method]":'GetClientsList',
                        "data[clname]":$('#clt-clientCampListWrp').data("clname")
                    },
                    success:function (data, textStatus) {
                        if( data.data) {
                          //alert('success'); 
                          $file2_cltClientCampListWrp.empty();
                          $("#clt-clientCompListTmpl").tmpl(data.data).appendTo($file2_cltClientCampListWrp);
                         


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
 
    f_file1_getClientsCampList();
    
//    $file1_cltClientListWrp.delegate(".clt-client","mouseenter",function(){
//        $(this).addClass("clt-clientHgl");
//    })
//     $file1_cltClientListWrp.delegate(".clt-client","mouseleave",function(){
//        $(this).removeClass("clt-clientHgl");
//    })
 
 
});