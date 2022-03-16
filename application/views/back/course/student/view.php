<div id="main">
    <header>
        <?php $this->load->view("include/navbar");?>
    </header> 
    <div id="main-content"> 
		<div class="page-title mb-3">
			<div class="row">
				<div class="col-12 col-md-6 order-md-1 order-last">
					<h3><?= $view->student_name_ar?></h3>
					<p class="text-subtitle text-muted"><?= json_decode($info->course_title)->ar?></p>
				</div>
				<div class="col-12 col-md-6 order-md-2 order-first">
					<nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="<?= site_url()?>">الرئيسية</a></li> 
							<li class="breadcrumb-item"><a href="<?= site_url()?>/course">الدورات المتاحة</a></li>  
							<li class="breadcrumb-item"><a href=""><?= json_decode($info->course_title)->ar?></a></li>  
							<li class="breadcrumb-item active">عرض الطالب المسجل <?= $view->student_name_ar?></li>
						</ol>
					</nav>
				</div>
			</div>
		</div>
		<div class="page-heading"> 
			<form id="form" method="post" action="course/course_student_update" class="form form-horizontal needs-validation" novalidate>
				<input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>">
				<input type="hidden" name="course_available_id" value="<?=$view->course_available_id?>">
				<input type="hidden" name="course_student_id" value="<?=$view->course_student_id?>">
				<div class="row">
					<div class="col-xl-4 col-lg-6">
						<div class="card">
							<div class="card-content">
								<div class="card-body">
									<div class="form-body">
										<div class="row mb-3">
											<div class="col-md-12">
												<div class="d-flex justify-content-between mb-3">
													<label>اسم الطالب الطالب</label> 
												</div>
											</div>
											<div class="col-md-12 form-group">
												<select class="choices form-control" name="student_id" disabled>
													<option value="" selected disabled> الرجاء اختيار اسم الطالب</option>
													<?php
													$student = get_student();
													foreach($student as $s){
													?>
													<option value="<?= $s->student_id?>" <?php if($view->student_id == $s->student_id) echo "selected";?>><?= $s->student_name_ar?></option>
													<?php }?>
												</select>
												<div class="invalid-feedback"> الرجاء اختيار طالب</div>
											</div>
										</div>
										<div class="row">
											<div class="col-sm-12 form-group">
												<div class="form-check">
                                                    <div class="checkbox">
                                                        <input type="checkbox" id="pay_seat_reservation" class="form-check-input" <?php if($view->pay_seat_reservation == 1) echo "checked";?>>
                                                        <label for="pay_seat_reservation"> هل تم دفع رسوم حجز المقعد ؟</label>
														<input type="hidden" name="pay_seat_reservation" class="pay_seat_reservation_value" value="<?= $view->pay_seat_reservation?>">
                                                    </div>
                                                </div>
											</div>
										</div>
										<div class="row voucher_number <?php if($view->pay_seat_reservation == 0) echo 'd-none';?>">
											<div class="col-sm-12 form-group">
												<label>رقم الوصل</label>
												<input type="tel" class="form-control text-start" name="voucher_number" placeholder="الرجاء ادخال رقم الوصل "  value="<?= $view->voucher_number?>">
											</div>
										</div> 
										<div class="row">
											<div class="col-md-12">
												<label>ملاحظات</label>
											</div>
											<div class="col-md-12 form-group">
												<textarea rows="5" class="form-control" name="reg_note" ><?= strip_tags($view->reg_note)?></textarea>
											</div>
										</div>

										<div class="row">
											<div class="col-sm-12 d-flex">
												<button type="submit" class="btn btn-primary btn-submit me-2 mb-1">
													<span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span> حفظ التغيرات
												</button>
												<a href="course/course_student/<?= $info->course_available_id;?>" class="btn btn-light-secondary mb-1"> الغاء</a>
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
	
	$("#pay_seat_reservation").on("click", function(){
		var btnCheck = $(this);

		if(btnCheck.is(':checked')){
			$(".voucher_number").removeClass("d-none");
			$(".voucher_number input").attr("required","required");
			$(".pay_seat_reservation_value").val(1);
			
		} else {
			$(".voucher_number").addClass("d-none");
			$(".voucher_number input").removeAttr("required");
			$(".pay_seat_reservation_value").val(0);
		}
	});

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