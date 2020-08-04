<div class="modal fade" id="addStockCategoryModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle"><i class="fa fa-check">&nbsp;</i>Stock Category</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    <br />
      <div class="modal-body">
        <small id="location_error" class="form-text text-muted"></small>
          <form id="addStockCategoryForm" onsubmit="return false">
            <div class="form-group">
            <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text" id="basic-addon3"><i class="fa fa-edit">&nbsp;</i>Category</span>
            </div>

            <input type="text" class="form-control" id="stock_category" name="stock_category" aria-describedby="basic-addon3">
            
        </div>

      </div>
        <br />
          <br />
            <button type="submit" class="btn btn-outline-info"><i class="fa fa-file">&nbsp;</i>Add</button>
          </form>
        
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-outline-warning" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>