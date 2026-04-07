<div class="modal fade" id="modalExcelCB" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <form id="frmExcelCB" enctype="multipart/form-data"> 
        @csrf 
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Load file</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <label for="logo" class="form-label">Archivo Excel</label>
            <input id="excelCB" name="excelCB" type="file" accept=".xlsx,.xls" required data-browse-on-zone-click="true">
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Process</button>
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
          </div>
        </div>
      </form>
    </div>
</div>