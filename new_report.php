<?php
if(!isset($conn)){
	include 'db_connect.php' ;
}
?>
<div class="col-lg-12">
	<div class="card">
		<div class="card-body">
		<form action="" id="manage_staff">
                <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
                <div class="row">
                    <div class="col-md-6 border-right">
                        <b class="text-muted">معلومات التقرير</b>
                        <div class="form-group">
                            <label for="" class="control-label">عنوان التقرير</label>
                            <input type="text" name="report_title" class="form-control form-control-sm" required value="<?php echo isset($report_title) ? $report_title : '' ?>">
                        </div>
                        <div class="form-group">
                            <label for="" class="control-label">الوصف</label>
                            <textarea name="description" cols="30" rows="4" class="form-control" required><?php echo isset($description) ? $description : '' ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="" class="control-label">التاريخ</label>
                            <input type="date" name="report_date" class="form-control form-control-sm" required value="<?php echo isset($report_date) ? $report_date : '' ?>">
                        </div>
                        <div class="form-group">
                            <label for="" class="control-label">الملاحظات</label>
                            <textarea name="notes" cols="30" rows="4" class="form-control"><?php echo isset($notes) ? $notes : '' ?></textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="control-label">القسم</label>
                            <select name="department_id" id="department_id" class="custom-select custom-select-sm select2">
                                <option value=""></option>
                                <?php
                                $department = $conn->query("SELECT * FROM departments ORDER BY name ASC");
                                while ($row = $department->fetch_assoc()):
                                ?>
                                    <option value="<?php echo $row['id'] ?>" <?php echo isset($department_id) && $department_id == $row['id'] ? "selected" : '' ?>><?php echo ucwords($row['name']) ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label">اسم المستخدم</label>
                            <input type="text" class="form-control form-control-sm" name="user_name" required value="<?php echo isset($user_name) ? $user_name : '' ?>">
                        </div>
                    </div>
                </div>
				<hr>
				<div class="col-lg-12 text-right justify-content-center d-flex">
					<button class="btn btn-primary mr-2">Save</button>
					<button class="btn btn-secondary" type="reset">Clear</button>
				</div>
			</form>
		</div>
	</div>
</div>
<script>
	// $('[name="password"],[name="cpass"]').keyup(function(){
	// 	var pass = $('[name="password"]').val()
	// 	var cpass = $('[name="cpass"]').val()
	// 	if(cpass == '' ||pass == ''){
	// 		$('#pass_match').attr('data-status','')
	// 	}else{
	// 		if(cpass == pass){
	// 			$('#pass_match').attr('data-status','1').html('<i class="text-success">Password Matched.</i>')
	// 		}else{
	// 			$('#pass_match').attr('data-status','2').html('<i class="text-danger">Password does not match.</i>')
	// 		}
	// 	}
	// })
	// function displayImg(input,_this) {
	//     if (input.files && input.files[0]) {
	//         var reader = new FileReader();
	//         reader.onload = function (e) {
	//         	$('#cimg').attr('src', e.target.result);
	//         }

	//         reader.readAsDataURL(input.files[0]);
	//     }
	// }
	$('#manage_staff').submit(function(e){
        e.preventDefault();
        $('input, textarea').removeClass("border-danger");
        start_load();
        
        $.ajax({
            url: 'ajax.php?action=save_report',
            data: new FormData($(this)[0]),
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            type: 'POST',
            success: function(resp) {
                if (resp == 2) {
                    alert_toast('تم حفظ البيانات بنجاح.', "success");
                    setTimeout(function() {
                        location.replace('index.php?page=staff_list');
                    }, 750);
                } else if (resp == 2) {
                    alert_toast('حدث خطأ أثناء حفظ التقرير.', "danger");
                    end_load();
                }
            }
        });
    });
</script>