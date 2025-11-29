<!-- Vendor js -->
<script src="{{URL::asset('/assets/js/vendor.min.js')}}"></script>
<!-- TODO js-->
<script src="{{URL::asset('/assets/js/pages/jquery.todo.js')}}"></script>
<!-- App js -->
<script src="{{URL::asset('/assets/js/app.min.js')}}"></script>
<!-- Boostrap Table -->
<script src="{{URL::asset('/assets/libs/bootstrap-table/bootstrap-table.min.js')}}"></script>
<script src="{{URL::asset('/assets/libs/bootstrap-table/bootstrap-table-locale-all.min.js')}}"></script>

<!-- Moment -->
<script src="{{URL::asset('/assets/libs/moment/min/moment.min.js')}}"></script>
<!-- ULID -->
<script src="{{URL::asset('/assets/libs/ulid/ulid.2.3.0.js')}}"></script>
<!-- Select 2 -->
<script src="{{URL::asset('/assets/libs/select2/js/select2.min.js')}}"></script>
<!-- switchery -->
<script src="{{URL::asset('/assets/libs/mohithg-switchery/switchery.min.js')}}"></script>
<!-- toastr -->
<script src="{{URL::asset('/assets/libs/toastr/build/toastr.min.js')}}"></script>
<!-- sweetalert -->
<script src="{{ URL::asset('/assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>

<script type="text/javascript">
    jQuery.fn.extend({
        toggleText: function (a, b){
            var that = this;
                if (that.text() != a && that.text() != b){
                    that.text(a);
                }
                else
                if (that.text() == a){
                    that.text(b);
                }
                else
                if (that.text() == b){
                    that.text(a);
                }
            return this;
        }
    });

    function tool_tips(){
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl, {
                trigger : 'hover'
            });
        });
    }

    function init_popover(){
        var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
        var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
            return new bootstrap.Popover(popoverTriggerEl,{html: true})
        });
    }

    $.fn.initSwitchery = function() {
        $('[data-plugin="switchery"]').each(function() {
            new Switchery($(this)[0], $(this).data());
        });
    };

    function showToast(message, type='info', timeout=5500,position='toast-top-center') {
        type = (type=='partial') ? 'warning' : type;
        
        toastr.options.timeOut = timeout;
        toastr.options.positionClass = position;
        toastr.options.closeButton = true;
        toastr[type](message);
    }

    ///Confirmar pregunta
    async function confirmQuestion(question, text = null) {
        const config = {
            title: question,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes',
            cancelButtonText: 'No',
            buttonsStyling: false,
            customClass: {
                closeButton: 'btn btn-danger ms-1',
                confirmButton: 'btn btn-success ms-1',
                cancelButton: 'btn btn-danger ms-1',
            },
            allowOutsideClick: false,
            allowEscapeKey: false
        };

        if (text !== null) {
            config.html = text;
        }

        const result = await Swal.fire(config);

        return result.isConfirmed;
    }

    function loadingSwal(show = true) {
        if (show) {
            Swal.fire({
                title: 'Processing...',
                html: 'Please wait while the command is executed.',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
        } else {
            Swal.close();
        }
    }

    function sendRequest(uri, method, data, callback) {
        let ajaxOptions = {
            url: uri,
            type: method,
            dataType: "json",
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            beforeSend: function () {
                loadingSwal(true);
            },
            success: function(response) {
                if (typeof callback === 'function') {
                    callback(response);
                }
            },
            error: function(xhr, status, error) {
                const errorMsg = xhr.responseJSON?.mensaje || 
                                xhr.responseJSON?.message || 
                                xhr.responseJSON?.error || 
                                'An error occurred when processing the request';
                showToast(errorMsg, 'error');
                loadingSwal(false);
            },
            complete: function () {
                setTimeout(() => {
                    loadingSwal(false);
                }, 500);
            }
        };

        if (data !== null && data !== undefined) {
            if (data instanceof FormData) {
                ajaxOptions.data = data;
                ajaxOptions.processData = false;
                ajaxOptions.contentType = false;
            } else {
                ajaxOptions.data = JSON.stringify(data);
                ajaxOptions.contentType = "application/json";
            }
        }

        $.ajax(ajaxOptions);
    }

    function slugify(text) {
        return text
            .toString()
            .toLowerCase()
            .trim()
            .replace(/\s+/g, '-')           // Reemplaza espacios con -
            .replace(/[^\w\-]+/g, '')       // Elimina caracteres no válidos
            .replace(/\-\-+/g, '-');        // Reemplaza múltiples - por uno
    }
</script>
@yield('script')
@yield('script-bottom')