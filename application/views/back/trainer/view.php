<div id="main">
    <header>
        <?php $this->load->view("include/navbar");?>
    </header> 
    <div id="main-content"> 
		<div class="page-title mb-3">
			<div class="row">
				<div class="col-12 col-md-6 order-md-1 order-last">
					<h3><?= $view->trainer_name_ar?></h3>
					<p class="text-subtitle text-muted">عرض بيانات المدرب</p>
				</div>
				<div class="col-12 col-md-6 order-md-2 order-first">
					<nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="<?= site_url()?>">الرئيسية</a></li> 
							<li class="breadcrumb-item"><a href="<?= site_url()?>trainer"> المدربين</a></li> 
							<li class="breadcrumb-item active"><?= $view->trainer_name_ar?> </li> 
						</ol>
					</nav>
				</div>
			</div>
		</div>
		<div class="page-heading"> 
			<form id="form" method="post" action="trainer/update_trainer" class="form form-horizontal needs-validation" enctype="multipart/form-data" novalidate>
				<input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">
				<input type="hidden" name="trainer_id" value="<?= $view->trainer_id?>">
				<input type="hidden" name="last_trainer_pic" value="<?= $view->trainer_pic?>">
				<div class="row"> 
					<div class="col-xl-3 col-lg-4">
						<div class="card"> 
							<div class="card-content">
								<div class="card-body">
									<div class="form-body">
										<div class="row mb-4">
											<div class="col-md-12">
												<label>صورة المدرب</label>
											</div> 
											<div class="col-md-12 text-center"> 
												<div class="upload-pic-box">
													<label for="profile_pic" class="view-pic">
														<img src="<?= site_url().$view->trainer_pic?>" class="img-fluid rounded preview-pic" width="150">
													</label>
													<input type="file" class="form-control d-none upload-pic" id="profile_pic" name="trainer_pic" id="formFile">
													<div class="invalid-feedback">الرجاء ارفاق صورة</div> 
													<p>
														 يرجى ادراج صورة بالابعاد التالية 
														<code dir="ltr" style="direction : ltr">(120px × 120px)</code>
													</p> 
												</div>	 
											</div>
										</div> 
									</div> 
								</div> 
							</div> 
						</div> 
					</div> 
					<div class="col-xl-4 col-lg-6">
						<div class="card"> 
							<div class="card-content">
								<div class="card-body">
									<div class="form-body"> 
										<div class="row"> 
											<div class="col-md-12">
												<label>اسم المدرب بالعربية</label>
											</div>
											<div class="col-md-12 form-group">
												<input type="text" class="form-control" name="trainer_name_ar" value="<?= $view->trainer_name_ar?>" required> 
											</div>
										</div>
										<div class="row"> 
											<div class="col-md-12">
												<label>اسم المدرب بالانجليزية</label>
											</div>
											<div class="col-md-12 form-group">
												<input type="text" class="form-control" dir="ltr" name="trainer_name_en" value="<?= $view->trainer_name_en?>" required> 
											</div>
										</div>
										<div class="row"> 
											<div class="col-md-12">
												<label>رقم الهوية</label>
											</div>
											<div class="col-md-12 form-group">
												<input type="tel" class="form-control" name="trainer_idno" value="<?= $view->trainer_idno?>" required>
											</div>
										</div>
										
										<div class="row"> 
											<div class="col-md-12">
												<label>الجنس</label>
											</div>
											<div class="col-md-12 form-group">
												<select class="choices" name="trainer_gender" required>
													<option value="" selected disabled> الرجاء اختيار الجنس</option>
													<option value="1" <?php if($view->trainer_gender == 1) echo "selected";?>>ذكر</option>
													<option value="0" <?php if($view->trainer_gender == 0) echo "selected";?>>انثى</option>
												</select>
											</div>
										</div>
										<div class="row"> 
											<div class="col-md-12">
												<label>تاريخ الميلاد</label>
											</div>
											<div class="col-md-12 form-group">
												<input type="text" class="form-control date" name="trainer_dob" value="<?= $view->trainer_dob?>" required> 
											</div>
										</div>
									</div>
								</div> 
							</div>
						</div>
					</div> 
					<div class="col-xl-4 col-lg-6">
						<div class="card"> 
							<div class="card-content">  
								<div class="card-body">
									<div class="form-body">
										 
										<div class="row"> 
											<div class="col-md-12">
												<label>البريد الالكتروني</label>
											</div>
											<div class="col-md-12 form-group">
												<input type="email" class="form-control" name="trainer_email" value="<?= $view->trainer_email?>" required> 
											</div>  
										</div>
										<div class="row"> 
											<div class="col-md-12">
												<label>رقم الجوال</label>
											</div>
											<div class="col-md-12 form-group">
												<input type="tel" class="form-control" name="trainer_phone" value="<?= $view->trainer_phone?>" required> 
											</div>
										</div>
										<div class="row"> 
											<div class="col-md-12">
												<label>رقم الهاتف</label>
											</div>
											<div class="col-md-12 form-group">
												<input type="tel" class="form-control" name="trainer_tel" value="<?= $view->trainer_tel?>" required> 
											</div>
										</div>
										<div class="row"> 
											<div class="col-md-12">
												<label>الفرع</label>
											</div>
											<div class="col-md-12 form-group">
												<select class="choices" name="branch_id" require>
													<option value="" selected disabled> الرجاء اختيار الفرع</option>
													<?php 
													$branch = get_branch();
													foreach($branch as $b){
													?>
													<option value="<?= $b->branch_id?>" <?php if($view->branch_id == $b->branch_id) echo "selected";?>><?= $b->branch_name?></option> 
													<?php }?>
												</select>
											</div>
										</div>
										<div class="row"> 
											<div class="col-md-12">
												<label>العنوان بالتفصيل</label>
											</div>
											<div class="col-md-12 form-group">
												<input type="text" class="form-control" name="trainer_address" value="<?= $view->trainer_address?>" required> 
											</div>
										</div>
									</div>
								</div>  
							</div>  
						</div>  
					</div>  
				</div>
				
				<div class="row">
					<div class="col-sm-12 d-flex">
						<button type="submit" class="btn btn-primary btn-submit me-2 mb-1">
							<span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span> حفظ التغيرات
						</button>
						<a href="<?= site_url()?>trainer" class="btn btn-light-secondary mb-1"> الغاء</a>
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
				//data: form.serialize(), 
				data:new FormData(this),
				processData:false,
				contentType:false,
				cache:false,
				async:false,
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
					}, 3000);
				},
				error: function() {
					Swal.fire("خطأ !!", "حدث خطأ غير متوقع ، يرجى المحاولة مرة اخرى", "error");
				}
			});
		}
    });
</script>