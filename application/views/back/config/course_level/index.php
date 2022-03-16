<?php 
	$courseInfo = get_course_id($course_id);
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
							<li class="breadcrumb-item active" aria-current="page">مستويات <?= $courseName?></li>
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
							<h4 class="card-title">مستويات <?= $courseName?></h4>
							<p class="footer">جلب البيانات في <strong>{elapsed_time}</strong> ثانية.</p> 
							<a href="config/course_level_add/<?=$course_id?>" class="btn btn-primary"> اضافة مستوى جديد</a>
						</div>
						<div class="card-content">
							<div class="card-body"> 
								<table class="table mb-0">
									<tr>
										<td>#</td>
										<td>اسم المستوى</td>
										<td>عدد الساعات</td>
										<td>سعر المستوى</td>
										<td>خيارات</td>
									</tr>
									<?php foreach($view as $v){?>
									<tr>
										<td><?= $v->level_id;?></td>
										<td><?= $v->level_name?></td>
										<td><?= $v->level_hours?></td>
										<td><?= $v->level_price?></td>
										<td class="text-bold-500">
											<a class="btn btn-primary" href="config/course_level_view/<?= $v->level_id;?>"> تعديل</a>
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