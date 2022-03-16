<div id="main">
    <header>
        <?php $this->load->view("include/navbar");?>
    </header> 
    <div id="main-content"> 
		<div class="page-title mb-3">
			<div class="row">
				<div class="col-12 col-md-6 order-md-1 order-last">
					<h3>مجموعات الدورة</h3>
					<p class="text-subtitle text-muted">عرض المجموعات المسجلين في دورة <?= json_decode($info->course_title)->ar?></p>
				</div>
				<div class="col-12 col-md-6 order-md-2 order-first">
					<nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="<?= site_url()?>">الرئيسية</a></li> 
							<li class="breadcrumb-item"><a href="<?= site_url()?>/course">الدورات المتاحة</a></li>  
							<li class="breadcrumb-item"><a href=""><?= json_decode($info->course_title)->ar?></a></li>  
							<li class="breadcrumb-item active">عرض المجموعات المسجلين</li> 
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
							<h4 class="card-title">عرض مجموعات الدورة <?= json_decode($info->course_title)->ar?></h4>
							<p class="footer">جلب البيانات في <strong>{elapsed_time}</strong> ثانية.</p>
						</div>
						<div class="card-content">
							<div class="card-body"> 
								<div class="row">
									<div class="col-xl-3 col-lg-4 col-md-6 column">
										<h6 class="title mb-4"> الطلاب المسجلين في الدورة</h6>
										<ul class="connected-sortable droppable-area1 nav flex-column h-100">
											<?php 
												foreach($student as $s){
											?>
											<li class="draggable-item"><?= $s->student_name_ar?></li>
											<?php } ?>
										</ul>
									</div>
									<div class="col-xl-3 col-lg-4 col-md-6 column ">
										<h6 class="title mb-4"> طلاب المجموعة</h6>
										<ul class="connected-sortable droppable-area2 nav flex-column border h-100">
											<?php 
												foreach($view as $v){
											?>
											<li class="draggable-item"><?= $v->student_name_ar?></li>
											<?php }?>
										</ul>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div> 
			</div> 
		</div>
	</div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
<script>
	$( ".droppable-area1, .droppable-area2" ).sortable({
		connectWith: ".connected-sortable",
		stack: '.connected-sortable ul'
    }).disableSelection();
</script>