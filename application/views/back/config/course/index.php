<div id="main">
    <header>
        <?php $this->load->view("include/navbar");?>
    </header> 
    <div id="main-content"> 
		<div class="page-title mb-3">
			<div class="row">
				<div class="col-12 col-md-6 order-md-1 order-last">
					<h3>صفحة الدورات</h3>
					<p class="text-subtitle text-muted">الدورات المتاحة في المركز</p>
				</div>
				<div class="col-12 col-md-6 order-md-2 order-first">
					<nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="<?= site_url()?>">الرئيسية</a></li>
							<li class="breadcrumb-item"><a href="<?= site_url()?>config">الاعدادات</a></li>
							<li class="breadcrumb-item active" aria-current="page">صفحة الدورات</li>
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
							<h4 class="card-title">صفحة الدورات</h4>
							<p class="footer">جلب البيانات في <strong>{elapsed_time}</strong> ثانية.</p> 
							<a href="config/new_course" class="btn btn-primary"> اضافة دورة جديدة</a>
						</div>
						<div class="card-content">
							<div class="card-body"> 
								<table class="table mb-0">
									<tr>
										<td>#</td>
										<td>اسم الدورة</td>
										<td>عدد المستويات</td>
										<td>عدد الساعات</td>
										<td>السعر</td>
										<td>الحالة</td>
										<td>تفعيل / تعطيل</td>
										<td>خيارات</td>
									</tr>
									<?php foreach($view as $v){?>
									<tr>
										<td><?= $v->course_id;?></td>
										<td><?= json_decode($v->course_title)->ar?></td>
										<td><?= count(get_course_level($v->course_id))?></td>
										<td><?= $v->course_hours?></td>
										<td><?= $v->course_price?></td>
										<td>
											<?php if($v->course_active == 1){
												$checked = "checked";
											?>
												<span class="badge bg-success badge-lang-<?= $v->course_id;?>">مفعل</span>
											<?php } else{
												$checked = "";
											?>
												<span class="badge bg-danger badge-lang-<?= $v->course_id;?>">غير مفعل</span>
											<?php }?>
										</td>
										<td class="text-bold-500">
											<div class="form-check form-switch form-switch-success">
												<input class="form-check-input" type="checkbox" data-id="<?= $v->course_id;?>" value="<?= $v->course_active;?>" <?= $checked ?> >
											</div>
										</td>
										<td class="text-bold-500">
											<div class="dropdown">
												<a class="btn btn-primary dropdown-toggle" type="button" id="triggerId" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
													الخيارات
												</a>
												<div class="dropdown-menu dropdown-menu-end" aria-labelledby="triggerId">
													<a class="dropdown-item" href="config/view_course/<?= $v->course_id;?>"> تعديل </a>
													<a class="dropdown-item" href="config/course_level/<?= $v->course_id;?>"> المستويات</a>
												</div>
											</div> 
										</td>
									</tr>	
									<?php } ?>
								</table> 
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
			$(".badge-lang-"+ id).removeClass("bg-success").addClass("bg-danger").text("غير مفعل");
		} else {
			$(".badge-lang-"+ id).removeClass("bg-danger").addClass("bg-success ").text("مفعل");
		}
		$.ajax({
			type: "post",
			dataType: "html",
			url: "config/update_course_status",
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