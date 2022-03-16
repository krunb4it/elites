<div id="main">
    <header>
        <?php $this->load->view("include/navbar");?>
    </header> 
    <div id="main-content"> 
		<div class="page-title mb-3">
			<div class="row">
				<div class="col-12 col-md-6 order-md-1 order-last">
					<h3>طلاب الدورة</h3>
					<p class="text-subtitle text-muted">عرض الطلاب المسجلين في دورة <?= json_decode($info->course_title)->ar?></p>
				</div>
				<div class="col-12 col-md-6 order-md-2 order-first">
					<nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="<?= site_url()?>">الرئيسية</a></li> 
							<li class="breadcrumb-item"><a href="<?= site_url()?>/course">الدورات المتاحة</a></li>  
							<li class="breadcrumb-item"><a href=""><?= json_decode($info->course_title)->ar?></a></li>  
							<li class="breadcrumb-item active">عرض الطلاب المسجلين</li> 
						</ol>
					</nav>
				</div>
			</div>
		</div>
		
		<div class="page-heading"> 
			<div class="row">
				<div class="col-lg-12">
					<div class="card">
						<div class="card-header">
							<h4 class="card-title">عرض الطلاب المسجلين في دورة <?= json_decode($info->course_title)->ar?></h4>
							<p class="footer">جلب البيانات في <strong>{elapsed_time}</strong> ثانية.</p>
							<a class="btn btn-primary" href="course/course_student_add/<?= $info->course_available_id?>"> تسجيل طالب جديد </a>
						</div>
						<div class="card-content">
							<div class="card-body">
								
								<?php if(!empty($view)) { ?>
								<table class="table table-borderless mb-0">
									<tr> 
										<th>#</th>
										<th>اسم الطالب</th>
										<th>تاريخ التسجيل</th> 
										<th>حجز المقعد</th>
										<th>المجموعة</th>
										<th>ملاحظات</th>
										<th></th>
									</tr>
									<?php  
									foreach($view as $v){
										if (! file_exists($v->student_pic)) {
											$student_img = '<div class="avatar avatar-lg bg-primary me-2">
														<span class="avatar-content"><i class="iconly-boldProfile"></i></span>
													</div>';
										} else {
											$student_img = '<div class="avatar avatar-lg me-2"><img src="'. site_url().$v->student_pic .'" alt="" srcset=""></div>';
										}
										if (! file_exists($v->user_pic)) {
											$admin_img = '<div class="avatar bg-primary me-2" data-bs-toggle="tooltip" data-bs-original-title="'. $v->user_name.'">
														<span class="avatar-content"><i class="iconly-boldProfile"></i></span>
													</div>';
										} else {
											$admin_img = '<div class="avatar me-2" data-bs-toggle="tooltip" data-bs-original-title="'. $v->user_name.'"><img src="'. site_url().$v->user_pic .'" alt="" srcset=""></div>';
										}
									?>
									<tr id="student_id_<?= $v->course_student_id;?>">
										<td > 
											<div class="form-check">
												<input class="form-check-input" type="checkbox" value="" name="student_check[<?= $v->student_id?>]"> 
											</div>
										</td>
										<td ><?= $student_img . $v->student_name_ar?></td>
										<td ><?= $admin_img .'<i class="bi bi-clock mx-2"></i> '.$v->reg_date?> </td>
										<td >
											<?php
												if($v->pay_seat_reservation == 1) {
													echo '<span class="badge bg-light-success"> تم الدفع </span> <br> <small> رقم الايصال '.  $v->voucher_number .'</small>';

												} else { 
													echo '<span class="badge bg-light-danger"> لم يتم الدفع</span>';
												}
											 
											?>
										</td>
										<td ><?= $v->group_name?></td>
										<td ><?= $v->reg_note?></td>
										<td ><a href="course/course_student_view/<?= $v->course_student_id;?>/<?= $info->course_available_id?>" class="btb btn-sm btn-primary">تعديل</a></td>
									</tr>
									<?php } ?>
								</table>
								<?php } else {?>
									<div class="alert alert-secondary">
                                        <h4 class="alert-heading">لا يوجد بيانات</h4>
                                        <p> لا يوجد طلاب مسجلين في هذه الدورة ، قم بتسجيل طلاب في هذه الدورة</p> 
                                    </div>
								<?php }?>
							</div>
						</div>
					</div>
				</div> 
			</div> 
		</div>
	</div>
</div>


<script> 
	// change status
	$(".form-switch").on("click", function(e){
		var val = $(this).find(".form-check-input").val();
		var id = $(this).find(".form-check-input").data("id"); 
		
		(val == 0) ? val = 1 : val = 0;
		$(this).find(".form-check-input").val(val);
		
		if(val == 0){
			$(".badge-lang-"+ id).removeClass("bg-success ").addClass("bg-danger").text("غير مفعل");
		} else {
			$(".badge-lang-"+ id).removeClass("bg-danger").addClass("bg-success ").text("مفعل");
		}
		$.ajax({
			type: "post",
			dataType: "html",
			url: "<?= site_url()?>course/update_course_status",
			data: {
				"course_active" : val,
				"course_id" : id,
				"<?=$this->security->get_csrf_token_name();?>":"<?=$this->security->get_csrf_hash();?>"
			},
			success: function(res){ 
				var res = JSON.parse(res);
				runToastify(res.res);
			},
			error: function(){ 
			}
		});
	}); 
	
	// remove
	$('.btn-remove').click( function(e){
		e.preventDefault();
		var id = $(this).data("id");
		Swal.fire({
			icon: 'warning',
			title: "حذف الطالب",
			text: 'هل تريد حقاً حذف الطالب ' + $(this).data("title") + ' ، مع العلم لا يمكنك استعادة بيانات الطالب المحذوف',
			showCancelButton: true,
			confirmButtonText: 'نعم',
			cancelButtonText: 'الغاء', 
			}).then((result) => { 
			if (result.isConfirmed) {
				$.ajax({
					type: "post",
					dataType: "html",
					url: "<?= site_url()?>course/remove_course_id",
					data: {
						"course_id" : id,
						"<?=$this->security->get_csrf_token_name();?>":"<?=$this->security->get_csrf_hash();?>"
					},
					success: function(res){ 
						var res = JSON.parse(res);
						$("#course_id_"+ id).remove();
						runToastify(res.res);
					},
					error: function(){ 
					}
				});
			} else if (result.isDenied) {
				Swal.fire('Changes are not saved', '', 'info')
			}
		});
	});
</script> 