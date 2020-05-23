<!-- Group List -->
<nav class="col-lg-2 col-md-3 col-4 bg-light sidebar">
    <div class="sidebar-sticky">
        <ul class="nav flex-column"></ul>
    </div>
</nav>

<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">New Group</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="?action=aCreateGroup" method="post">
                <div class="modal-body">
                        <div class="form-group row">
                            <label for="inputGroupName" class="col-sm-2 col-form-label">Name</label>
                            <div class="col-sm-10">
                                <input name="name" type="text" class="form-control" id="inputGroupName" required />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="userQuery" class="col-sm-2 col-form-label">Add Member</label>
                            <div class="col-sm-10">
                                <input id="userQuery" class="form-control" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputGroupName" class="col-sm-2 col-form-label">Members</label>
                            <div id="members" class="col-sm-10"></div>
                        </div>
                        <input name="users" id="userIds" hidden />
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary" type="submit">Create</button>
                </div>
            </form>
        </div>
    </div>
</div>