<?php 
	$course_id = $view->course_id;
	$courseInfo = get_course_id($view->course_id);
	$courseName = json_decode($courseInfo->course_title)->ar; 
?>
<div id="main">
    <header>
        <?php $this->load->view("include/navbar");?>
    </header> 
    <div id="main-content"> 
		<div class="page-title mb-3">
			<div class="row">
				<div class="col-12 col-md-6 order-md-1 order-last">
					<h3>مستويات <?= $courseName?></h3>
					<p class="text-subtitle text-muted">الدورات المتاحة في المركز</p>
				</div>
				<div class="col-12 col-md-6 order-md-2 order-first">
					<nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="">الرئيسية</a></li>
							<li class="breadcrumb-item"><a href="config">الاعدادات</a></li>
							<li class="breadcrumb-item"><a href="config/course">الدورات</a></li> 
							<li class="breadcrumb-item"><a href="config/course_level/<?=$course_id?>">المستويات</a></li> 
							<li class="breadcrumb-item active" aria-current="page">تعديل <?=  $view->level_name?></li>
						</ol>
					</nav>
				</div>
			</div>
		</div>
		<div class="page-heading"> 
			<form id="form" method="post" action="config/update_level" class="form form-horizontal needs-validation" novalidate>
				<input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">
				<input type="hidden" name="course_id" value="<?= $view->course_id?>"> 
				<input type="hidden" name="level_id" value="<?= $view->level_id?>"> 
				
				<div class="row">
					<div class="col-lg-6">
						<div class="card"> 
							<div class="card-content">
								<div class="card-body">
									<div class="form-body">
										<div class="row"> 
											<div class="col-md-3">
												<label>اسم المستوى</label>
											</div>
											<div class="col-md-9 form-group">
												<input type="text" class="form-control" name="level_name" value="<?= $view->level_name?>" required > 
											</div>
										</div>
										<div class="row"> 
											<div class="col-md-3">
												<label>عدد الساعات</label>
											</div>
											<div class="col-md-9 form-group">
												<input type="text" class="form-control" name="level_hours" value="<?= $view->level_hours?>" required > 
											</div>
										</div> 
										<div class="row"> 
											<div class="col-md-3">
												<label>سعر الدورة</label>
											</div>
											<div class="col-md-9 form-group">
												<input type="text" class="form-control" name="level_price" value="<?= $view->level_price?>" required > 
											</div>
										</div>
										
										<hr class="my-4">

										<div class="row">
											<div class="col-sm-12 d-flex justify-content-end">
												<button type="submit" class="btn btn-primary btn-submit me-2 mb-1">
													<span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span> حفظ التغيرات
												</button>
												<a href="config/course_level/<?= $course_id?>" class="btn btn-light-secondary mb-1"> الغاء</a>
											</div> 
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>  
			</form> 
		</div>
	</div>
</div>

<script>
	$('.form').submit(function(e) {
		var form = $(this);
		if (form[0].checkValidity() === false) {
            e.stopPropagation();
        } else {
			e.preventDefault(); 
			form.find(".btn-submit .spinner-border").toggleClass("d-none");
			form.addClass("disabled");
			$.ajax({
				type: "post", 
				dataType: "html",
				url: form.attr("action"),
				data: form.serialize(),
				/*
				data:new FormData(this),
				processData:false,
				contentType:false,
				cache:false,
				async:false,
				*/
				success: function(res){
					var res = JSON.parse(res);
					setTimeout( function(){
						if(res.status == "error"){
							Swal.fire("خطأ !!", res.res, "error");
						} else {
							runToastify(res.res);
						}
						form.find(".btn-submit .spinner-border").toggleClass("d-none");
						form.removeClass("disabled");
					}, 2000);
				},
				error: function() {
					Swal.fire("خطأ !!", "حدث خطأ غير متوقع ، يرجى المحاولة مرة اخرى", "error");
				}
			});
		}
    });
</script>