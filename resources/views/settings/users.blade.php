@extends('layouts.master-vertical')

@section('title') {{config('app.name')}} | User Settings @endsection
@section('content')
@section('pagetitle') User Settings @endsection
<!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">User Settings</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">{{config('app.name')}}</a></li>
                        <li class="breadcrumb-item active">User Settings</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>     
    <!-- end page title --> 

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <form  class="needs-validation" novalidate id="frmUserSettings">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row mb-3">
                                    <label class="col-md-3 col-form-label" for="codebar">Barcode Type</label>
                                    <div class="col-md-9">
                                        <select class="form-select new" name="codebar" id="codebar" required>
                                            <option value="CODE128">CODE 128</option>
                                            <option value="EAN13">EAN 13</option>
                                            <option value="EAN8">EAN 8</option>
                                            <option value="EAN5">EAN 5</option>
                                            <option value="CODE39">CODE 39</option>
                                            <option value="UPC">UPC</option>
                                            <option value="ITF14">ITF 14</option>
                                        </select>
                                        <div class="invalid-feedback text-danger">
                                            Please select an option.
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row mb-3">
                                    <label class="col-md-6 col-form-label" for="qrCode">QR code</label>
                                    <div class="col-md-6">
                                        <div class="form-check form-switch">
                                            <input type="checkbox" data-plugin="switchery" data-color="#1bb99a" data-secondary-color="#ff5d48" id="qrCode"/>
                                            <label class="form-check-label" for="qrCode" id="lblqrCode">NO</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="button" class="btn btn-danger" id="cerrar">
                            <i class="mdi mdi-close-thick mdi-18px "></i>
                            Close
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="mdi mdi-content-save-outline mdi-18px "></i>
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- end row -->
@endsection
@section('script')
<script>
    $('.new').select2({
        theme: "bootstrap-5",
        //width: "90%",
        placeholder: "Select...",
    });

    $(document).ready(function(){
        
        $(document).initSwitchery();

        $('.new').val(null).trigger('change');

        $('#qrCode').on('change',function(){
            $('#lblqrCode').toggleText('YES', 'NO');
        });

        $('#frmUserSettings').on('submit',function(e){
            e.preventDefault();

            let form = $(this);
            if(!form[0].checkValidity())  return false;
            let qrCode = $('#qrCode').is(':checked');
            let datos = form.serialize();
            datos += '&qrCode='+qrCode;

            $.post('{{ route("userSettings.save")}}',datos)
            .done(function(data){
                showToast(data.msg,data.success);
            })
            .fail(function(daterror) {
                console.log(daterror);
                showToast('An error occurred while processing the data',"error");
            })
        })

        loadData();
    });

    function loadData() {
        userID = {{ Auth::user()->id }};
        url = '{{ route("userSettings.list", ":id") }}';
        url = url.replace(":id", userID);

        $.get(url)
            .done(function(data) {
                $.each(data, function(k, v) {
                    // Busca el elemento por ID
                    let $control = $('#' + v.key);

                    if ($control.length) {
                        if ($control.is('select')) {
                            // Si es un select, asigna el valor y dispara el evento change
                            $control.val(v.value).trigger('change');
                        } else if ($control.is(':checkbox')) {
                            // Si es un checkbox, verifica el valor y realiza acciones adicionales
                            if (v.value === "true") {
                                $control.trigger('click'); // Marca el checkbox y dispara el evento click
                                $('#lblqrCode').text('YES'); // Cambia el texto del label
                            } 
                        } else if ($control.is(':input')) {
                            // Si es otro tipo de control (input, textarea, etc.), solo asigna el valor
                            $control.val(v.value);
                        }
                    }
                });
            });
    }

</script>
@endsection