
$(function(){
    $(document).ready(function() {
        $('.select2').select2({            
            placeholder: {
                id: '-1',
                text: 'Select an option'
            },
        });
    });
    
    $(document).on('submit','#ajax-form, .ajax-form', function(e){
        e.preventDefault();
        let form = $(this);
        let method = form.attr('method'); 
        let button = form.find('button[type=submit]');
        let buttonText = button.html();
        button.text('Loading...');
        button.attr('disabled',true);        
        let progress = form.find('.progress-bar');
        progress.html("0%");
        progress.css("width","0px");
        let data = new FormData($(this)[0]); 
        $.ajax({
            xhr: function(){
                var xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener("progress", function(evt){
                    if(evt.lengthComputable){
                        var persentComplete = parseFloat( (evt.loaded / evt.total ) * 100 ).toFixed(2);
                        progress.css("width",persentComplete+"%");
                        progress.html(persentComplete+"%");
                    }
                }, false);
                return xhr;
            },
            type: method,
            url: form.attr("action"),
            data: data,
            contentType: false,
            cache: false,
            processData:false,
            success:function(output){
                if(output.modal){
                    $('.modal').modal('hide');
                }
                if(output.status){
                    successMessage(output.message, output.button);                
                }else{
                    errorMessage(output.message)
                }
                if(output.url){
                    window.location.href = output.url;
                }                
                if(output.table){
                    table.ajax.reload();
                }
                if(output.reset){
                    form.trigger("reset");
                } 
                if(output.html_page){
                    $('.modal .modal-dialog').html(output.html_page);  
                }             
                button.html(buttonText);
                button.removeAttr('disabled');
                if(output.table){
                    table2.ajax.reload();
                }
            },
            error : function(response){
                button.html(buttonText);
                button.removeAttr('disabled');
                errorMessage(getError(response));
            }
        });
    });

    
    $(document).on('click','.ajax-click, #ajax-click',function(e){
        e.preventDefault();
        if( confirm('Are you sure?')){            
            let self = $(this);
            let buttonText = self.html();
            self.html('wait...');
            $.ajax({
                url : $(this).attr('href'),
                method : 'GET',
                success : function(output){ 
                    self.html(buttonText);          
                    if(output.status){
                        successMessage(output.message, output.button);                
                    }else{
                        errorMessage(output.message)
                    }
                    if(output.url){
                        window.location.href = output.url;
                    }
                    if(output.table){
                        table.ajax.reload();;
                    }
                    if(output.html_page){
                        $('.modal .modal-dialog').html(output.html_page);  
                    } 
                    if(output.table){
                        table2.ajax.reload();
                    }                                                   
                },
                error : function (response){
                    self.html(buttonText)
                    errorMessage(getError(response));
                }
            });
        }
    });

    $(document).on('click','.ajax-click-without-confirm, #ajax-click-without-confirm',function(e){
        e.preventDefault();           
        let self = $(this);
        let buttonText = self.html();
        self.html('loading...');
        $.ajax({
            url : $(this).attr('href'),
            method : 'GET',
            success : function(output){ 
                self.html(buttonText);          
                if(output.status){
                    successMessage(output.message, output.button);                
                }else{
                    errorMessage(output.message)
                }
                if(output.url){
                    window.location.href = output.url;
                }
                if(output.table){
                    table.ajax.reload();
                    
                } 
                if(!output.html_page){
                    $('.modal .modal-dialog').html(output);  
                }
                
                if(output.table){
                    table2.ajax.reload();
                }
            },
            error : function (response){
                self.html(buttonText)
                errorMessage(getError(response));
            }
        });
    });


    $(document).on('click','.ajax-click-page, #ajax-click-page', function(e){
        e.preventDefault();
        let self = $(this);
        let modal = $('.modal');
        let buttonText = self.html();
        self.text('wait...');
        modal.modal('show');
        $.ajax({
            url : $(this).attr('href'),
            success : function(output){              
                $('.modal .modal-dialog').html(output);                
                self.html(buttonText);
                $(".select2").select2();
            },
            error : function (response){                
                self.html(buttonText)                
                errorMessage(getError(response));    
                modal.modal('hide');            
            }
        });
    });

    $(document).on('click','.user-auth', function(e){
        e.preventDefault();
        let self = $(this);
        let modal = $('.auth-modal');
        let buttonText = self.html();
        modal.modal('show');
        $.ajax({
            url : $(this).attr('href'),
            success : function(output){              
                $('.auth-modal').html(output);                
                self.html(buttonText);
            },
            error : function (response){                
                self.html(buttonText)                
                errorMessage(getError(response));    
                modal.modal('hide');            
            }
        });
    });

    var typingTimer;
	var self;
    $(document).on("keyup", ".verify", function(){
        clearTimeout(typingTimer);
		self = $(this);
        typingTimer = setTimeout(verifyNow, 1500);
    });

    function verifyNow () {
        let verify_type = self.data('verify_type');
        let value = self.val();
		$.ajax({
			url : "/validate",
			data : {
				field : verify_type,
				field_value : value
			},
			success:function(output){
				// console.log(output);
				if(output.status){
					self.removeClass("is-invalid");
					self.addClass("is-valid");
				}else{
					self.addClass("is-invalid");
					self.removeClass("is-valid")
				}

			}
		});
    }
});

function getError(response){
    // console.log(response);
    let message =  response.responseJSON.message;
    message += response.responseJSON.file ? ' on ' + response.responseJSON.file : "";
    message += response.responseJSON.line ? ' on Line : ' + response.responseJSON.line : "";
    return message;
}

function successMessage(message = null, button = false){
    Swal.fire({
        type: 'success',
        // icon: 'success',
        html: message,
        showConfirmButton: button ? true : false,
        timer: button ? 100000 : 2000
    }); 
}

function errorMessage(message = null){
    Swal.fire({
        type: 'error',
        title: 'Oops...',
        html: message === null ?'Something went Wrong':message,
    });
}

