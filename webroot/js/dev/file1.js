/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
jQuery(document).ready(function(){
    var $file1;
    
    
    var f_file1_getClients = function(){
 
                $.ajax({
                    dataType:"json",
                    url: "\/yzk.go\/campaigns\/getYnData",
                    type: "POST",
                    data: {
                        "data[method]":'',
                        "data[param]":'{"Login":"am_borovikov"}'
                    },
                    success:function (data, textStatus) {
                        if( data.data) {
                          alert('success');                           
                        } else if(data.error){
                           alert(data.error);
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
 
    f_file1_getClients();
    
});