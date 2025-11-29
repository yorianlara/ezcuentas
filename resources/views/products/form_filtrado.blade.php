<div class="btn-group" role="group">
    <button class="btn btn-dark dropdown-toggle me-1" type="button" data-bs-toggle="dropdown" data-bs-auto-close="false" aria-expanded="false">
        <i class="mdi mdi-filter-menu-outline"></i>
        Filter
    </button>
    <form class="dropdown-menu p-1" style="min-width: 500px;">
        <div class="filter-container">
            <div class="form-group">
                <label>Filtering logic:</label>
                <select id="logic-select" class="form-select">
                    <option value="and">AND (all conditions)</option>
                    <option value="or">OR (any condition)</option>
                </select>
            </div>
            <div class="input-group mt-3">
                <select class="form-select" id="column-select">
                    <option value="" selected>Select column</option>
                    <option value="sku">SKU</option>
                    <option value="name">Name</option>
                    <option value="product_type">Type</option>
                    <option value="category">Category</option>
                    <option value="qty">Qty.</option>
                    <option value="color">Color</option>
                    <option value="status">Status</option>
                </select>
                <select class="form-select" id="operator-select">
                    <option value="E">is equal</option>
                    <option value="NE">is no equal</option>
                    <option value="IS NULL">is empty</option>
                    <option value="NOT IS NULL">is no empty</option>
                    <option value="ILIKE-S">starts with</option>
                    <option value="ILIKE-E">ends with</option>
                    <option value="IN">is one of</option>
                    <option value="NOT IN">is not one of</option>
                    <option value="ILIKE-C">content</option>
                    <option value="ILIKE-NC">no content</option>
                </select>
                <span id="value-container">
                    <input type="text" class="form-control" id="filter-value" placeholder="Value">
                </span>
                <button type="button" id="add-filter" class="btn btn-primary">+</button>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-check mt-2">
                        <input class="form-check-input" type="checkbox" id="hide_status" checked>
                        <label class="form-check-label" for="hide_status">
                            Hide Archived and hidden
                        </label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-check mt-2">
                        <input class="form-check-input" type="checkbox" id="show_types" checked>
                        <label class="form-check-label" for="show_types">
                            Only standard and parents
                        </label>
                    </div>
                </div>
            </div>
            <div class="mt-2" id="filters-container">
                <input type="hidden" name="filterLogic" id="filterLogic" value="and">
                <div class="filter-item d-none" id="filter-1750358767828">
                    <input type="hidden" name="filterColumn[1750358767]" value="status">
                    <input type="hidden" name="filterOperator[1750358767]" value="NOT IN">
                    <input type="hidden" name="filterValue[1750358767]" value="archived,hide">
                </div>
                <div class="filter-item d-none" id="filter-1750358690736">
                    <input type="hidden" name="filterColumn[1750358690]" value="product_type">
                    <input type="hidden" name="filterOperator[1750358690]" value="IN">
                    <input type="hidden" name="filterValue[1750358690]" value="standard,parent">
                </div>
            </div>
            
            <div class="mt-3">
                <button type="button" id="clear-filters" class="btn btn-danger btn-action">Clear Filters</button>
            </div>
        </div>
      </form>
</div>