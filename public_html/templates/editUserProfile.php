<div class="modal fade" id="editUsersProfileModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header bg-yellowish" style="color:#eee;">
        <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-edit">&nbsp;</i><span id="userProfileName"></span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
         <small id="d_success" class="form-text text-muted"></small>
        <form id="editUserProfileForm" onsubmit="return false">
          <div class="form-row">
            <div class="form-group col-md-6">
          <label>Full Name<span style="color:red">&nbsp;*</span></label>
          <input type="hidden" id="edit_user_id">
          <input type="text" class="form-control" id="edit_fullname" required/>
        </div>
        <div class="form-group col-md-6">
          <label>User name<span style="color:red">&nbsp;*</span></label>
          <input type="text" class="form-control" id="edit_username" required/>
        </div>
          </div>
          

        <div class="form-row">
        <div class="form-group col-md-6">
          <label>Email</label>
          <input type="text" id="edit_email" class="form-control" required>
        </div>
        <div class="form-group col-md-3">
        <label>User Type</label>
        <select class="form-control" id="edit_user_type" required/>
        <option value="Admin">Admin</option>
        <option value="Other">Other</option>>       
          </select>
      </div>
      <div class="form-group col-md-3">
        <label>Status</label>
        <select class="form-control" id="edit_user_status" required/>
        <option value="Active">Active</option>
        <option value="Inactive">Inactive</option>       
          </select>
      </div>
          
      </div>
     
      
      <button type="submit" class="btn btn-block btn-secondary">Edit Profile</button>
    </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary bg-yellowish" data-dismiss="modal">Close</button>
        
      </div>
    </div>
  </div>
</div>

