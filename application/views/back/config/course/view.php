<div id="main">
    <header>
        <?php $this->load->view("include/navbar");?>
    </header> 
    <div id="main-content"> 
		<div class="page-title mb-3">
			<div class="row">
				<div class="col-12 col-md-6 order-md-1 order-last">
					<h3><?= json_decode($view->course_title)->ar?></h3>
					<p class="text-subtitle text-muted">تعريف الدورات </p>
				</div>
				<div class="col-12 col-md-6 order-md-2 order-first">
					<nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="<?= site_url()?>">الرئيسية</a></li>
							<li class="breadcrumb-item"><a href="<?= site_url()?>config">الاعدادات</a></li>
							<li class="breadcrumb-item"><a href="<?= site_url()?>config/course">تعريف الدورات</a></li>
							<li class="breadcrumb-item active" aria-current="page">دورة  <?= json_decode($view->course_title)->ar?></li>
						</ol>
					</nav>
				</div>
			</div>
		</div>
		<div class="page-heading"> 
			<form id="form" method="post" action="<?= site_url()?>config/update_course" class="form form-horizontal needs-validation" enctype="multipart/form-data" novalidate>
				<input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">
				<input type="hidden" name="course_id" value="<?= $view->course_id?>"> 
				
				<div class="row"> 
					<div class="col-lg-6"> 
						<div class="card">
							<div class="card-header">
								<h4 class="card-title"><?= json_decode($view->course_title)->ar?></h4> 
							</div>
							<div class="card-content">
								<div class="card-body">
									<div class="form-body"> 
										<?php foreach($language as $l){
											$short = $l->lang_short;
										?>
										<div class="">
											<h5 class="pb-3"><?= $l->lang_name?></h5>
											<div class="row"> 
												<div class="col-md-3">
													<label>اسم الدورة</label>
												</div>
												<div class="col-md-9 form-group">
													<input type="text" class="form-control form-control-lg" name="course_title[<?= $short?>]" required value="<?= json_decode($view->course_title)->$short?>" > 
												</div>
											</div> 
											<div class="row"> 
												<div class="col-md-3">
													<label>تفاصيل الدورة</label>
												</div>
												<div class="col-md-9 form-group">
													<textarea rows="10" type="text" class="form-control form-control-lg textarea-editor" id="course_details_<?= $short?>" name="course_details[<?= $short?>]" required><?= json_decode($view->course_details)->$short?></textarea>
												</div>
											</div>
											<div class="row"> 
												<div class="col-md-3">
													<label>كلمات دليلة</label>
												</div>
												<div class="col-md-9 form-group">
													<input type="text" class="form-control form-control-lg tagsinput d-none" name="course_tags[<?= $short?>]" required value="<?= json_decode($view->course_tags)->$short?>">
												</div> 
											</div>
										</div> 
										<hr class="my-3"> 
										
										<?php }?> 
									</div>
								</div>
							</div>
						</div>
					</div> 
					<div class="col-lg-6">
						<div class="card">
							<div class="card-header">
								<h4 class="card-title">بيانات اضافية</h4> 
							</div>
							<div class="card-content">
								<div class="card-body">
									<div class="form-body">
										<div class="row"> 
											<div class="col-md-3">
												<label>عدد الساعات</label>
											</div>
											<div class="col-md-9 form-group">
												<input type="text" class="form-control form-control-lg" name="course_hours" value="<?= $view->course_hours?>" required > 
											</div>
										</div>
										<div class="row"> 
											<div class="col-md-3">
												<label>عدد الطلاب</label>
											</div>
											<div class="col-md-9 form-group">
												<input type="text" class="form-control form-control-lg" name="course_capacity" value="<?= $view->course_capacity?>" required > 
											</div>
										</div>
										<div class="row"> 
											<div class="col-md-3">
												<label>سعر الدورة</label>
											</div>
											<div class="col-md-9 form-group">
												<input type="text" class="form-control form-control-lg" name="course_price" value="<?= $view->course_price?>" required > 
											</div>
										</div>
										<div class="row"> 
											<div class="col-md-3">
												<label>العملة</label>
											</div>
											<div class="col-md-9 form-group">
												<select class="choices form-control" name="currency_id" required>
													<option value="" disabled selected> الرجاء اختار العملة</option>
													<?php 
													$get_currency = get_currency();
													foreach($get_currency as $c){?>
													<option value="<?= $c->currency_id?>" <?php if($view->currency_id == $c->currency_id) echo "selected";?> ><?= json_decode($c->currency_name)->ar?></option>
													<?php }?>
												</select>
											</div>
										</div>

										<hr class="my-4">

										<div class="row">
											<div class="col-sm-12 d-flex justify-content-end">
												<button type="submit" class="btn btn-primary btn-submit me-2 mb-1">
													<span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span> حفظ التغيرات
												</button>
												<a href="<?= site_url()?>config/course" class="btn btn-light-secondary mb-1"> الغاء</a>
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