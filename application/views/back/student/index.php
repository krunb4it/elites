<div id="main">
    <header>
        <?php $this->load->view("include/navbar");?>
    </header> 
    <div id="main-content"> 
		<div class="page-title mb-3">
			<div class="row">
				<div class="col-12 col-md-6 order-md-1 order-last">
					<h3>الطلاب</h3>
					<p class="text-subtitle text-muted">عرض كافة الطلاب</p>
				</div>
				<div class="col-12 col-md-6 order-md-2 order-first">
					<nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="<?= site_url()?>">الرئيسية</a></li> 
							<li class="breadcrumb-item active">الطلاب</li> 
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
							<h4 class="card-title">الطلاب</h4>
							<p class="footer">جلب البيانات في <strong>{elapsed_time}</strong> ثانية.</p>
							<a class="btn btn-primary" href="<?=site_url()?>student/new_student"> اضافة طالب جديد</a>
						</div>
						<div class="card-content">
							<div class="card-body"> 
								<table class="table table-borderless mb-0">
									<tr> 
										<td>اسم الطالب</td> 
										<td>البريد الالكتروني</td>
										<td>رقم الجوال</td>
										<td>الفرع</td>
										<td>الحالة</td>
										<td>تفعيل/ تعطيل</td>
										<td>خيارات</td>
									</tr>
									<?php foreach($view as $s){
										if (! file_exists($s->student_pic)) {
											$img = '<div class="avatar avatar-lg bg-primary me-2">
														<span class="avatar-content"><i class="iconly-boldProfile"></i></span>
													</div>';
										} else {
											$img = '<div class="avatar avatar-lg me-2"><img src="'. site_url().$s->student_pic .'" alt="" srcset=""></div>';
										}
									?>
									<tr id="student_id_<?= $s->student_id;?>"> 
										<td >
											
											<?=  $img . $s->student_name_ar?>
										</td> 
										<td > <?=  $s->student_email?> </td>
										<td > <?=  $s->student_phone?> </td>
										<td > <?=  $s->branch_name?> </td>
										<td width="80">
											<?php if($s->student_active == 1){
												$checked = "checked";
											?>
											<span class="badge bg-success badge-lang-<?= $s->student_id;?>">مفعل</span>
											<?php } else{
												$checked = "";
											?>
											<span class="badge bg-danger badge-lang-<?= $s->student_id;?>">محظور</span>
											<?php }?>
										</td>
										<td width="50" class="text-bold-500">
											<div class="form-check form-switch">
												<input class="form-check-input" type="checkbox" data-id="<?= $s->student_id;?>" value="<?= $s->student_active;?>" <?= $checked ?> >
											</div>
										</td>
										<td width="150" class="text-bold-500">
											<a class="btn btn-primary me-2" href="<?=site_url()?>student/view_student/<?= $s->student_id;?>"> تعديل</a>
											<a class="btn btn-danger btn-remove" href="#!" data-id="<?= $s->student_id;?>" data-title="<?= $s->student_name_ar?>"> <i class="bi bi-trash"></i> </a>
										</td>
									</tr>	
									<?php }?>
								</table>

								<?php if(isset($links)) echo $links?>
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
			url: "<?= site_url()?>student/update_student_status",
			data: {
				"student_active" : val,
				"student_id" : id,
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
					url: "<?= site_url()?>student/remove_student_id",
					data: {
						"student_id" : id,
						"<?=$this->security->get_csrf_token_name();?>":"<?=$this->security->get_csrf_hash();?>"
					},
					success: function(res){ 
						var res = JSON.parse(res);
						$("#student_id_"+ id).remove();
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