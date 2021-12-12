<div id="modal_group" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="post" id="form_group" class="form-horizontal">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title title_group"></h4>
        </div>
        <div class="modal-body" style="margin-bottom: -20px;">
          <div id="name_group_class" class="form-group">
            <label class="col-sm-3 control-label">Name:</label>
            <div class="col-sm-9">
              <input type="text" name="name_group" id="name_group" class="form-control" maxlength="15" placeholder="" required />
              <span id="name_group_message" class="help-block"></span>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label">Comment:</label>
            <div class="col-sm-9">
              <textarea name="comment_group" id="comment_group" class="form-control" rows="3" placeholder=""></textarea>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <input type="hidden" name="id_edit_group" id="id_edit_group" />
          <input type="hidden" name="name_edit_group" id="name_edit_group" />
          <input type="hidden" name="action_group" id="action_group" />
          <button type="button" class="btn btn-flat btn-gray" style="width: 55px;" data-dismiss="modal" title="Close">Close</button>
          <input type="submit" value="Save" class="btn btn-flat btn-orange" style="width: 55px;" title="Save" />
        </div>
      </form>
    </div>
  </div>
</div>

<div id="modal_user" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="post" id="form_user" class="form-horizontal">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title title_user"></h4>
        </div>
        <div class="modal-body" style="margin-bottom: -20px;">
          <div id="barcode_user_class" class="form-group">
            <label class="col-sm-3 control-label">Barcode:</label>
            <div class="col-sm-9">
              <input type="text" name="barcode_user" id="barcode_user" class="form-control" minlength="15" maxlength="15" placeholder="" required />
              <span id="barcode_user_message" class="help-block"></span>
            </div>
          </div>
          <?php if ($user_role == 'IT') { $query_users = 'groups'; ?>
          <div class="form-group">
            <label class="col-sm-3 control-label">Role:</label>
            <div class="col-sm-9">
              <select name="role_user" id="role_user" class="form-control select2" style="width: 100%;" required>
                <option value="IT">IT</option>
                <option value="AM">AM</option>
                <option value="TL">TL</option>
              </select>
            </div>
          </div>
          <?php } else { $query_users = 'groups_user'; } ?>
          <div class="form-group">
            <label class="col-sm-3 control-label">Group:</label>
            <div class="col-sm-9">
              <select name="group_user[]" id="group_user" class="form-control select2" multiple="multiple" style="width: 100%;" required>
              <?php
              $array_groups = groups($query_users, $user_id, 'id_name');
              foreach ($array_groups as $value_group) {
              ?>
                <option value="<?php echo $value_group['id']; ?>"><?php echo $value_group['name']; ?></option>
              <?php } ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label">Comment:</label>
            <div class="col-sm-9">
              <textarea name="comment_user" id="comment_user" class="form-control" rows="3" placeholder=""></textarea>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <input type="hidden" name="id_edit_user" id="id_edit_user" />
          <input type="hidden" name="barcode_edit_user" id="barcode_edit_user" />
          <input type="hidden" name="action_user" id="action_user" />
          <button type="button" class="btn btn-flat btn-gray" style="width: 55px;" data-dismiss="modal" title="Close">Close</button>
          <input type="submit" value="Save" class="btn btn-flat btn-orange" style="width: 55px;" title="Save" />
        </div>
      </form>
    </div>
  </div>
</div>

<div id="modal_team" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="post" id="form_team" class="form-horizontal">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title title_team"></h4>
        </div>
        <div class="modal-body" style="margin-bottom: -20px;">
          <div id="name_team_class" class="form-group">
            <label class="col-sm-3 control-label">Name:</label>
            <div class="col-sm-9">
              <input type="text" name="name_team" id="name_team" class="form-control" maxlength="15" placeholder="" required />
              <span id="name_team_message" class="help-block"></span>
            </div>
          </div>
          <?php
          if ($user_role != 'TL') {
            if ($user_role == 'IT') {
              $query_teams = 'owners';
            } else {
              $query_teams = 'owners_group';
            }
          ?>
          <div id="owner_team_class" class="form-group">
            <label class="col-sm-3 control-label">Owner:</label>
            <div class="col-sm-9">
              <select name="owner_team[]" id="owner_team" class="form-control select2" multiple="multiple" style="width: 100%;" required>
              <?php
              $array_owners = owners($query_teams, $user_group, 'id_barcode');
              foreach ($array_owners as $value_owner) {
              ?>
                <option value="<?php echo $value_owner['id']; ?>"><?php echo $value_owner['barcode']; ?></option>
              <?php } ?>
              </select>
              <span id="owner_team_message" class="help-block"></span>
            </div>
          </div>
          <?php } ?>
          <div class="form-group">
            <label class="col-sm-3 control-label">Comment:</label>
            <div class="col-sm-9">
              <textarea name="comment_team" id="comment_team" class="form-control" rows="3" placeholder=""></textarea>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <input type="hidden" name="id_edit_team" id="id_edit_team" />
          <input type="hidden" name="name_edit_team" id="name_edit_team" />
          <input type="hidden" name="action_team" id="action_team" />
          <button type="button" class="btn btn-flat btn-gray" style="width: 55px;" data-dismiss="modal" title="Close">Close</button>
          <input type="submit" value="Save" class="btn btn-flat btn-orange" style="width: 55px;" title="Save" />
        </div>
      </form>
    </div>
  </div>
</div>

<div id="modal_employee" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="post" id="form_employee" class="form-horizontal">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title title_employee"></h4>
        </div>
        <div class="modal-body" style="margin-bottom: -20px;">
          <div id="barcode_employee_class" class="form-group">
            <label class="col-sm-3 control-label">Barcode:</label>
            <div class="col-sm-9">
              <input type="text" name="barcode_employee" id="barcode_employee" class="form-control" maxlength="15" placeholder="" required />
              <span id="barcode_employee_message" class="help-block"></span>
            </div>
          </div>
          <?php
          if ($user_role == 'IT') {
            $query_employees = 'teams';
          }
          if ($user_role == 'AM') {
            $query_employees = 'teams_group';
          }
          if ($user_role == 'TL') {
            $query_employees = 'teams_user';
          }
          ?>
          <div class="form-group">
            <label class="col-sm-3 control-label">Team:</label>
            <div class="col-sm-9">
              <select name="team_employee" id="team_employee" class="form-control select2" style="width: 100%;" required>
              <?php
              if ($user_role != 'TL') {
                $array_teams = teams($query_employees, $user_group, 'id_name');
              } else {
                $array_teams = teams($query_employees, $user_id, 'id_name');
              }
              foreach ($array_teams as $value_team) {
              ?>
                <option value="<?php echo $value_team['id']; ?>"><?php echo $value_team['name']; ?></option>
              <?php } ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label">Comment:</label>
            <div class="col-sm-9">
              <textarea name="comment_employee" id="comment_employee" class="form-control" rows="3" placeholder=""></textarea>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <input type="hidden" name="id_edit_employee" id="id_edit_employee" />
          <input type="hidden" name="barcode_edit_employee" id="barcode_edit_employee" />
          <input type="hidden" name="action_employee" id="action_employee" />
          <button type="button" class="btn btn-flat btn-gray" style="width: 55px;" data-dismiss="modal" title="Close">Close</button>
          <input type="submit" value="Save" class="btn btn-flat btn-orange" style="width: 55px;" title="Save" />
        </div>
      </form>
    </div>
  </div>
</div>

<div id="modal_notification" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="post" id="form_notification" class="form-horizontal">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title title_notification"></h4>
        </div>
        <div class="modal-body" style="margin-bottom: -20px;">
        <?php
        if ($user_role == 'IT') {
          $query_teams = 'teams';
          $query_employees = 'employees';
        }
        if ($user_role == 'AM') {
          $query_teams = 'teams_group';
          $query_employees = 'employees_group';
        }
        if ($user_role == 'TL') {
          $query_teams = 'teams_user';
          $query_employees = 'employees_user';
        }
        ?>
          <div id="team_class" class="form-group">
            <label class="col-sm-3 control-label">Team:</label>
            <div class="col-sm-9">
              <select name="team[]" class="form-control select2" multiple="multiple" style="width: 100%;">
              <?php
                if ($user_role != 'TL') {
                  $array_teams = teams($query_teams, $user_group, 'id_name');
                } else {
                  $array_teams = teams($query_teams, $user_id, 'id_name');
                }
                foreach ($array_teams as $value_team) {
                ?>
                <option value="<?php echo $value_team['id']; ?>"><?php echo $value_team['name']; ?></option>
              <?php } ?>
              </select>
            </div>
          </div>
          <div id="employee_class" class="form-group">
            <label class="col-sm-3 control-label">Employees:</label>
            <div class="col-sm-9">
              <select name="employee[]" class="form-control select2" multiple="multiple" style="width: 100%;">
              <?php
              if ($user_role != 'TL') {
                $array_employees = employees($query_employees, $user_group, 'id_barcode');
              } else {
                $array_employees = employees($query_employees, $user_id, 'id_barcode');
              }
              foreach ($array_employees as $value_employee) {
              ?>
                <option value="<?php echo $value_employee['id']; ?>"><?php echo $value_employee['barcode']; ?></option>
              <?php } ?>
              </select>
              <span id="team_employee_message" class="help-block"></span>
            </div>
          </div>
          <div id="text_class" class="form-group">
            <label class="col-sm-3 control-label">Text:</label>
            <div class="col-sm-9">
              <textarea name="text" id="text" class="form-control" rows="3" placeholder=""></textarea>
              <span id="text_message" class="help-block"></span>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <input type="hidden" name="action_notification" id="action_notification" />
          <button type="button" class="btn btn-flat btn-gray" style="width: 55px;" data-dismiss="modal" title="Close">Close</button>
          <input type="submit" value="Send" class="btn btn-flat btn-orange" style="width: 55px;" title="Send" />
        </div>
      </form>
    </div>
  </div>
</div>

<div id="modal_delete" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="post" id="form_delete">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title title_delete"></h4>
        </div>
        <div class="modal-body">
          <span>Are you sure want to Delete?</span>
        </div>
        <div class="modal-footer">
          <input type="hidden" name="type_delete" id="type_delete" />
          <input type="hidden" name="id_delete" id="id_delete" />
          <input type="hidden" name="action_delete" id="action_delete" />
          <button type="button" class="btn btn-flat btn-gray" style="width: 55px;" data-dismiss="modal" title="NO">NO</button>
          <input type="submit" value="YES" class="btn btn-flat btn-orange" style="width: 55px;" title="YES" />
        </div>
      </form>
    </div>
  </div>
</div>

<div id="modal_logout" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="post">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title">Sign Out</h4>
        </div>
        <div class="modal-body">
          Are you sure you want to Sign Out?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-flat btn-gray" style="width: 80px;" data-dismiss="modal" title="NO">NO</button>
          <a href="logout.php" style="margin-left: 5px;">
            <button type="button" class="btn btn-flat btn-orange" style="width: 80px;" title="YES">YES</button>
          </a>
        </div>
      </form>
    </div>
  </div>
</div>