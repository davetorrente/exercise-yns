<div id="profileModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Modal title</h4>
            </div>
            <div class="alert" id="alertMessage" style="display: none;"></div>
            <div class="modal-body">
                <form class="form-horizontal" role="form" method="post" id="formProfile" enctype="multipart/form-data">
                    <div class="form-group">
                        <label class="col-lg-3 control-label">First name:</label>
                        <div class="col-lg-8">
                            <input class="form-control" id="firstname" name="firstname" type="text">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label">Last name:</label>
                        <div class="col-lg-8">
                            <input class="form-control" id="lastname" name="lastname" type="text">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Username:</label>
                        <div class="col-md-8">
                            <input class="form-control" id="username" name="username"  type="text" value="janeuser">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label">Email:</label>
                        <div class="col-lg-8">
                            <input class="form-control" id="email" name="email" type="text">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="upload" class="col-sm-3 control-label">Upload</label>
                        <div class="col-sm-8">
                            <input class="form-control" type="file" name="upload" id="upload" value="<?php echo 1; ?>" >
                            <span style="color:red"><?php echo isset($uploadError) ? $uploadError : ''; ?></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"></label>
                        <div class="col-md-8">
                            <button type="button" id="profSave" class="btn btn-primary">Save changes</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        </div>
                    </div>

                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->