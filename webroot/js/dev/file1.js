/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
jQuery(document).ready(function(){
    var $file1;
    
    
    var f_file1_getClientsList = function(){
 
                $.ajax({
                    dataType:"json",
                    url: "\/campaigns\/getYnData",
                    type: "POST",
                    data: {
                        "data[method]":'GetClientsList'
                        
                    },
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
 
    f_file1_getClientsList();
    
});