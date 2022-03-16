<div id="main">
    <header>
        <?php $this->load->view("include/navbar");?>
    </header> 
    <div id="main-content"> 
		<div class="page-title mb-3">
			<div class="row">
				<div class="col-12 col-md-6 order-md-1 order-last">
					<h3>الدورات المتاحة</h3>
					<p class="text-subtitle text-muted">الدورات المتاحة</p>
				</div>
				<div class="col-12 col-md-6 order-md-2 order-first">
					<nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="<?= site_url()?>">الرئيسية</a></li> 
							<li class="breadcrumb-item active">الدورات المتاحة</li> 
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
							<h4 class="card-title">الدورات المتاحة</h4>
							<p class="footer">جلب البيانات في <strong>{elapsed_time}</strong> ثانية.</p>
							<a class="btn btn-primary" href="course/new_course_available">الاعلان عند دورة جديدة</a>
						</div>
						<div class="card-content">
							<div class="card-body"> 
								<table class="table table-borderless mb-0">
									<tr> 
										<td></td>
										<td>بواسطة</td>
										<td>اسم الدورة</td>
										<td>انشاء الدورة</td>
										<td>سعر الدورة</td>
										<td>تاريخ التسجيل</td>
										<td>عدد المسجلين</td>
										<td>الحالة</td>
									</tr>
									<?php foreach($view as $v){
										if (! file_exists($v->user_pic)) {
											$img = '<div class="avatar avatar-lg bg-primary me-2">
														<span class="avatar-content"><i class="iconly-boldProfile"></i></span>
													</div>';
										} else {
											$img = '<div class="avatar avatar-lg me-2"><img src="'. site_url().$v->user_pic .'" alt="" srcset=""></div>';
										}
									?>
									<tr id="course_id_<?= $v->course_available_id;?>">
										<td>
											<div class="dropdown">
												<a class="btn px-3 text-center dropdown-toggle" type="button" id="triggerId" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
													<i class="bi bi-three-dots"></i>
												</a>
												<div class="dropdown-menu dropdown-menu-end" aria-labelledby="triggerId">
													<a class="dropdown-item" href="course/course_student/<?= $v->course_available_id;?>">الطلاب</a> 
													<a class="dropdown-item" href="course/course_group/<?= $v->course_available_id;?>">المجموعات</a> 
													<a class="dropdown-item" href="course/course_payments/<?= $v->course_available_id;?>">الدفعات</a>
													<a class="dropdown-item" href="course/view_course_available/<?= $v->course_available_id;?>">تعديل البيانات</a> 
												</div>
											</div> 
										</td>
										<td > <?= $img?></td>
										<td >
											<?= json_decode($v->course_title)->ar?>
											<?php
												if($v->level_id != 0){
													echo "<small><br> - ". $v->level_name."<small>";
												}
											?>
										</td>
										<td ><?= $v->course_available_create_at?></td>
										<td ><?= $v->course_available_price?></td>
										<td ><?= $v->reg_start_date . " - " .$v->reg_end_date?></td>
										<td > <span class="badge bg-light-success"><?= count(get_course_available_student($v->course_available_id))?></span></td>
										<td width="80"><span class="badge <?= $v->course_status_color?> badge-lang-<?= $v->course_status_id;?>"> <?= $v->course_status_title?></span></td>
										
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
</script>