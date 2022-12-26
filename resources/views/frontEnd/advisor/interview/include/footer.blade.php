                                    </div>
                                </div>
                            </div>                                
                        </div>                            
                    </div>
                </div>
            </div>
        </div>
    </div>  
    <script type="text/javascript" src="{{asset('backEnd/components/jquery-ui/js/jquery-ui.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('backEnd/components/popper.js/js/popper.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('backEnd/components/bootstrap/js/bootstrap.min.js')}}"></script>
    <!-- Yazra Datatable -->
    <script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
    <!-- jquery slimscroll js -->
    <script type="text/javascript" src="{{asset('backEnd/components/jquery-slimscroll/js/jquery.slimscroll.js')}}"></script>
    <!-- modernizr js -->
    <script type="text/javascript" src="{{asset('backEnd/components/modernizr/js/modernizr.js')}}"></script>
    <!-- Chart js -->
    <script type="text/javascript" src="{{asset('backEnd/components/chart.js/js/Chart.js')}}"></script>
    <!-- amchart js -->
    <script src="{{asset('backEnd/assets/pages/widget/amchart/amcharts.js')}}" type="text/javascript"></script>
    <script src="{{asset('backEnd/assets/pages/widget/amchart/serial.js')}}" type="text/javascript"></script>
    <script src="{{asset('backEnd/assets/pages/widget/amchart/light.js')}}" type="text/javascript"></script>
    <script src="{{asset('backEnd/assets/js/jquery.mCustomScrollbar.concat.min.js')}}" type="text/javascript"></script>
    <script type="text/javascript" src="{{asset('backEnd/assets/js/SmoothScroll.js')}}"></script>
    <script src="{{asset('backEnd/assets/js/pcoded.min.js')}}" type="text/javascript"></script>
    <!-- custom js -->
    <script src="{{asset('backEnd/assets/js/vartical-layout.min.js')}}" type="text/javascript"></script>
    <script type="text/javascript" src="{{asset('backEnd/assets/pages/dashboard/custom-dashboard.js')}}"></script>
    <script type="text/javascript" src="{{asset('backEnd/assets/js/script.min.js')}}"></script> 
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

    <script type="text/javascript" src="{{asset('backEnd/js/form.js')}}?v=04"></script> 
    
    <!-- Sweet Alert -->
   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>

    <!-- Ck Editor -->
    <script src="https://cdn.ckeditor.com/ckeditor5/22.0.0/classic/ckeditor.js"></script>
   
    @yield('script')

    <script>
        // Load CK Editor
        if($('.editor').length > 0){
            ClassicEditor.create( document.querySelector( '.editor' ) );
        }
        


        // Error Message
        function errorMessage(sms = null){
            Swal.fire({
                type: 'error',
                title: 'Oops...',
                text: sms === null ?'Something went wrong! Try again Later':sms
            });
        }

        //Success message
        function successMessage(sms = null){
            Swal.fire({
                type: 'success',
                title: sms === null ?'successfully':sms,
                showConfirmButton: false,
                timer: 3000
            }); 
        }

        $.fn.modal.Constructor.prototype._enforceFocus = function() {
            var $modalElement = this.$element;
            $(document).on('.modal',function(e) {
                if ($modalElement[0] !== e.target
                    && !$modalElement.has(e.target).length
                    && $(e.target).parentsUntil('*[role="dialog"]').length === 0) {
                    $modalElement.focus();
                }
            });
        };
</script>

    @if( isset($status) && $status)
        <script>
            successMessage('{{ $message }}'); 
        </script>
    @elseif(isset($status) && !$status )
        <script>
            errorMessage('{{ $message }}');
        </script>
    @else
        
    @endif
    
</body>
</html>
