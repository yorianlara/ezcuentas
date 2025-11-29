    <!-- Crear marcas -->
    <div class="modal fade" id="modalCategory" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form  class="needs-validation" novalidate id="frmCategory">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="titulo">Category</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="categorias">
                        
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="id" id="idCat" value="">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
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
    <!-- Crear Marca -->