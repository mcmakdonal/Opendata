<!-- Modal -->
<div class="modal fade" id="modal-download" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">×</button>
            <h4 class="modal-title">Information</h4>
        </div>
        <div class="modal-body">
            {!! Form::open(['url' => '#','class' => 'form-download', 'method' => 'post','files' => true]) !!}
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="first_name" class="control-label">ชื่อ : </label>
                        <input type="text" class="form-control" id="first_name" name="first_name" value="" placeholder="ชื่อ" required>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="last_name" class="control-label">นามสกุล : </label>
                        <input type="text" class="form-control" id="last_name" name="last_name" value="" placeholder="นามสกุล" required>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="description" class="control-label">รายละเอียด : </label>
                        <textarea class="form-control" name="description" id="description" style="resize: none;" placeholder="รายละเอียดการ Download"></textarea>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-success last-download">Download</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
        </div>
        </div>
        
    </div>
</div>