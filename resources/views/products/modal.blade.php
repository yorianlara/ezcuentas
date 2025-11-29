<!-- Modal -->
<div class="modal fade" id="modalAddItem" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form class="needs-validation" novalidate id="frmAddOption">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Add Option</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                @csrf
                <div class="modal-body" id="frmContent">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" id="cerrarAddItem">
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
<!-- END Modal -->