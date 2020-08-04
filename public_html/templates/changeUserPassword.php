<div class="modal fade" id="changeUserPasswordModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header bg-redish" style="color:#eee;">
        <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-edit">&nbsp;</i><span id="changePasswordProfileName"></span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
         <small id="d_success" class="form-text text-muted"></small>
        <form id="changeUserPasswordForm" onsubmit="return false">
          <div class="form-row">
            <div class="form-group col-md-6">
          <label>Old Password<span style="color:red">&nbsp;*</span></label>
          <input type="hidden" id="user_id_pwd">
          <input type="password" class="form-control" id="old_password" required/>
        </div>
        <div class="form-group col-md-6">
          <label>New Password<span style="color:red">&nbsp;*</span></label>
          <input type="password" class="form-control" id="new_password" required/>
        </div>
          </div>
     
      
      <button type="submit" class="btn btn-block btn-info">Change Password</button>
    </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary bg-redish" data-dismiss="modal">Close</button>
        
      </div>
    </div>
  </div>
</div>

