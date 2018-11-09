<!-- Modal -->
<div class="modal fade" id="modal-cat" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h4 class="modal-title">เพิ่มหมวดหมู่</h4>
            </div>
            <div class="modal-body">
                {!! Form::open(['url' => '/categories','class' => 'form-cat', 'method' => 'post']) !!}
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="cat_title" class="control-label">ชื่อหมวดหมู่ <span class="must-input">*</span> : </label>
                            <input type="text" class="form-control" name="cat_title" value="" placeholder="" required>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <button type="submit" class="btn btn-success">บันทึก</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">ยกเลิก</button>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
            <div class="modal-footer">

            </div>
        </div>
        
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modal-cat-edit" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h4 class="modal-title">แก้ไข หมวดหมู่</h4>
            </div>
            <div class="modal-body">
                {!! Form::open(['url' => '/categories','class' => 'form-cat', 'method' => 'put']) !!}
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="cat_title" class="control-label">ชื่อหมวดหมู่ <span class="must-input">*</span> : </label>
                            <input type="text" class="form-control" id="cat_title" name="cat_title" value="" placeholder="ชื่อหมวดหมู่" required>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <button type="submit" class="btn btn-success">บันทึก</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
            <div class="modal-footer">

            </div>
        </div>
        
    </div>
</div>