<!-- Modal -->
<div class="modal fade" id="modalDescription" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form class="needs-validation" novalidate id="frmDescription">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Edit Description</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="idDesc" id="idDesc">
                    <textarea class="form-control" name="" id="editDescription" required rows="6"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal" id="cerrarDescription">
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