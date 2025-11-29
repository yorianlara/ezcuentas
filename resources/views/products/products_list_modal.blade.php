<!-- Modal -->
<div class="modal fade" id="modalPriceList" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Select Listing Type</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <label for="pl_type1">All Customers</label>
                        <input type="radio" name="pl_type" id="pl_type1" value='1'>
                    </div>
                    <div class="col-md-6">
                        <label for="pl_type2">Customer Selection</label>
                        <input type="radio" name="pl_type" id="pl_type2" value='2'>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-12 d-none" id="divTableCustomer">
                        <table id="tableCustomers" class="table table-sm table-striped"
                            data-id-field="id" 
                            data-unique-id="id"
                            data-click-to-select="true"
                            data-query-params="queryParamsC"
                            data-url="{{ route('customers.list') }}">
                            <thead class="table-light">
                                <tr>
                                    <th data-field="state" data-width="10" data-checkbox="true" data-align="center"></th>
                                    <th data-field="id" data-width="10" data-sortable="true" data-align="center">#</th>
                                    <th data-field="full_name" data-sortable="true">Full Name</th>
                                    <th data-field="email" data-sortable="true">Email</th>
                                    <th data-field="phone_number" data-sortable="true">Phone Number</th>
                                    <th data-field="company" data-sortable="true">Company</th>
                                    <th data-field="category.id" data-visible="false">CategoryID</th>
                                    <th data-field="category.name" data-sortable="true">Category</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <hr>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <label for="pl_pdf">Export to PDF</label>
                        <input type="radio" name="pl_export" id="pl_pdf" value='pdf' checked>
                    </div>
                    <div class="col-md-6">
                        <label for="pl_xls">Export to XLS</label>
                        <input type="radio" name="pl_export" id="pl_xls" value='xls'>
                    </div>
                </div>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" id="cerrarPL">
                    <i class="mdi mdi-close-thick mdi-18px "></i>
                    Close
                </button>
                <button type="button" class="btn btn-primary" id="processPL">
                    <i class="mdi mdi-cogs mdi-18px "></i>
                    Process
                </button>
            </div>
        </div>
    </div>
</div>
<!-- END Modal -->