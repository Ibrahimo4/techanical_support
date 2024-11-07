<?php include 'db_connect.php'; ?>
<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <table class="table table-hover table-bordered" id="list">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>عنوان التقرير</th>
                        <th>الوصف</th>
                        <th>تاريخ التقرير</th>
                        <th>ملاحظات</th>
                        <th>اسم المستخدم</th>
                        <th>الإجراء</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    $qry = $conn->query("SELECT r.*, d.name as department_name FROM report r LEFT JOIN departments d ON r.department_id = d.id ORDER BY r.report_date DESC");
                    while ($row = $qry->fetch_assoc()):
                    ?>
                    <tr>
                        <th class="text-center"><?php echo $i++ ?></th>
                        <td><b><?php echo htmlspecialchars($row['report_title']) ?></b></td>
                        <td><?php echo htmlspecialchars($row['description']) ?></td>
                        <td><?php echo htmlspecialchars($row['report_date']) ?></td>
                        <td><?php echo htmlspecialchars($row['notes']) ?></td>
                        <td><?php echo htmlspecialchars($row['user_name']) ?></td>
                        <td class="text-center">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                                Action
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="./index.php?page=edit_report&id=<?php echo $row['id'] ?>">Edit</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item delete_report" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>">Delete</a>
                            </div>
                        </td>
                    </tr>    
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        $('#list').dataTable();
        $('.delete_staff').click(function(){
            _conf("Are you sure you want to delete this report?", "delete_staff", [$(this).attr('data-id')]);
        });
    });

    function delete_staff(id){
        start_load();
        $.ajax({
            url: 'ajax.php?action=delete_staff',
            method: 'POST',
            data: {id: id},
            success: function(resp){
                if(resp == 1){
                    alert_toast("Report successfully deleted", 'success');
                    setTimeout(function(){
                        location.reload();
                    }, 1500);
                }
            }
        });
    }
</script>
