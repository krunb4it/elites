<div id="main">
    <header>
        <?php $this->load->view("include/navbar");?>
    </header> 
    <div id="main-content"> 
		<div class="page-title mb-3">
			<div class="row">
				<div class="col-12 col-md-6 order-md-1 order-last">
					<h3>الاعلان عن دورة جديدة</h3>
					<p class="text-subtitle text-muted">الدورات المتاحة</p>
				</div>
				<div class="col-12 col-md-6 order-md-2 order-first">
					<nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="<?= site_url()?>">الرئيسية</a></li> 
							<li class="breadcrumb-item"><a href="<?= site_url()?>/course">الدورات المتاحة</a></li> 
							<li class="breadcrumb-item active">الاعلان عن دورة جديدة</li> 
						</ol>
					</nav>
				</div>
			</div>
		</div>
		<div class="page-heading"> 
			<form id="form" method="post" action="course/add_course_available" class="form form-horizontal needs-validation" novalidate>
				<input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">

				<div class="row">
					<div class="col-xl-4 col-lg-6">
						<div class="card"> 
							<div class="card-content">
								<div class="card-body">
									<div class="form-body">
										<div class="row">
											<div class="col-md-12">
												<label>اختر الدورة</label>
											</div>
											<div class="col-md-12 form-group">
												<select class="choices form-control" name="course_id" required onchange="get_level(this.value)">
													<option value="" selected disabled> الرجاء اختيار الدورة</option>
													<?php
													$course = get_course();
													foreach($course as $c){
													?>
													<option value="<?= $c->course_id?>"><?= json_decode($c->course_title)->ar?></option>
													<?php }?>
												</select>
											</div>
										</div>

										<div class="select_level row d-none">
											<div class="col-md-12">
												<label>اختر المستوى</label>
											</div>
											<div class="col-md-12 form-group">
												<div id="level_id"></div>
											</div>
										</div>

										<div class="row">
											<div class="col-sm-6 form-group">
												<label>سعر الدورة</label>
												<input type="number" class="form-control" name="course_available_price" required>
											</div> 
											<div class="col-sm-6 form-group">
												<label>رسوم حجز المقعد</label>
												<input type="number" class="form-control" name="seat_reservation" required>
											</div>
										</div>

										<div class="row"> 
											<div class="col-md-12">
												<label>تاريخ بداية ونهاية التسجيل</label>
											</div>
											<div class="col-sm-6 form-group">
												<input type="text" class="form-control date" name="reg_start_date" placeholder="بداية التسجيل" required>
											</div> 
											<div class="col-sm-6 form-group">
												<input type="text" class="form-control date" name="reg_end_date"  placeholder="انتهاء التسجيل"  required>
											</div>
										</div>

										<div class="row">
											<div class="col-md-12">
												<label>ملاحظات</label>
											</div>
											<div class="col-md-12 form-group">
												<textarea rows="5" class="form-control" name="course_available_note" required></textarea>
											</div>
										</div>

										<div class="row">
											<div class="col-sm-12 d-flex">
												<button type="submit" class="btn btn-primary btn-submit me-2 mb-1">
													<span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span> حفظ التغيرات
												</button>
												<a href="<?= site_url()?>course" class="btn btn-light-secondary mb-1"> الغاء</a>
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
				success: function(res){
					var res = JSON.parse(res);
					setTimeout( function(){
						if(res.status == "error"){
							Swal.fire("خطأ !!", res.res, "error");
						} else {
							runToastify(res.res);
							form[0].reset();
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
