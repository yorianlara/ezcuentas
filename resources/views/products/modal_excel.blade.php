<div class="modal fade" id="modalExcel" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Cargar Archivo</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form id="frmExcel" enctype="multipart/form-data">
                <label for="logo" class="form-label">Archivo Excel</label>
                <input id="excel" name="excel" type="file" accept=".xlsx,.xls" required data-browse-on-zone-click="true">
            </form>
        </div>
        {{-- <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
        </div> --}}
      </div>
    </div>
</div>