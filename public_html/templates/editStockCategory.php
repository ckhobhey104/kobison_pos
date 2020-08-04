<!-- Modal -->
<div class="modal fade" id="editStockCategoryModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle"><i class="fa fa-edit">&nbsp;</i>Edit Stock Category</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    <br />
      <div class="modal-body">
        <!-- <small id="location_error" class="form-text text-muted"></small> -->
          <form id="editStockCategoryForm" onsubmit="return false">
            <div class="form-group">
            <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text" id="basic-addon3"><i class="fa fa-edit">&nbsp;</i>Category Name</span>
            </div>
            <input type="hidden" id="edit_category_id" name="edit_category_id" value="">
            <input type="text" class="form-control" id="edit_category_name" name="edit_category_name" aria-describedby="basic-addon3">            
        </div>

      </div>
        <br />
        <div class="form-group">
           <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fa fa-pencil">&nbsp;</i>Status</span>
                </div>
            <select id="edit_select_category_status" class="form-control">
                <option value="Active">Active</option>
                <option value="Inactive">Inactive</option>
            </select>
                <!-- <textarea class="form-control" name="edit_location_desc" id="edit_location_desc" aria-label="With textarea"></textarea> -->
          </div>
        </div>
          <br />
            <button type="submit" class="btn btn-outline-info btn-block"><i class="fa fa-file">&nbsp;</i>Update</button>
          </form>
        
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-outline-warning" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>