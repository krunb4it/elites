<div id="sidebar" class="active">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header">
            <div class="d-flex justify-content-between">
                <div class="logo">
                    <a href="<?= site_url()?>"><img src="<?= site_url()?>assets/images/logo/logo.png" alt="Logo" srcset=""></a>
                </div>
                <div class="toggler">
                    <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                </div>
            </div>
        </div>
        <div class="sidebar-menu">
            <ul class="menu">
                <li class="sidebar-title">القائمة الرئيسية</li>

                <li class="sidebar-item active ">
                    <a href="<?= site_url()?>" class='sidebar-link'>
                        <i class="bi bi-house-door"></i>
                        <span> الرئيسية </span>
                    </a>
                </li>
                <li class="sidebar-item  " id="profile">
                    <a href="<?= site_url()?>profile" class='sidebar-link'>
                        <i class="bi bi-person"></i>
                        <span>الملف الشخصي</span>
                    </a>
                </li>
                <li class="sidebar-item  " id="config">
                    <a href="<?= site_url()?>config" class='sidebar-link'>
                        <i class="bi bi-gear"></i>
                        <span>اعدادات الموقع</span>
                    </a>
                </li>
                <li class="sidebar-item " id="course">
                    <a href="<?= site_url()?>course" class='sidebar-link'>
                        <i class="bi bi-tags"></i>
                        <span> الدورات </span>
                    </a>
                </li>
                <li class="sidebar-item " id="student">
                    <a href="<?= site_url()?>student" class='sidebar-link'>
                        <i class="bi bi-people"></i>
                        <span> الطلاب </span>
                    </a>
                </li>
                <li class="sidebar-item " id="trainer">
                    <a href="<?= site_url()?>trainer" class='sidebar-link'>
                        <i class="bi bi-briefcase"></i>
                        <span> المدربين </span>
                    </a>
                </li>
                <li class="sidebar-item " id="order">
                    <a href="<?= site_url()?>order" class='sidebar-link'>
                        <i class="bi bi-cart2"></i>
                        <span> طلبات الشراء </span>
                    </a>
                </li>
                <li class="sidebar-item " id="wallet">
                    <a href="<?= site_url()?>wallet" class='sidebar-link'>
                        <i class="bi bi-wallet"></i>
                        <span>المحفظة</span>
                    </a>
                </li>
                <li class="sidebar-item d-none" id="chat">
                    <a href="<?= site_url()?>chat" class='sidebar-link'>
                        <i class="bi bi-chat-square-text"></i>
                        <span>المراسلات</span>
                    </a>
                </li>
                <li class="sidebar-item d-none" id="report">
                    <a href="<?= site_url()?>report" class='sidebar-link'>
                        <i class="bi bi-clipboard-data"></i>
                        <span>تقارير واحصائيات</span>
                    </a>
                </li>
                <li class="sidebar-item d-none" id="notifications">
                    <a href="<?= site_url()?>notifications" class='sidebar-link'>
                        <i class="bi bi-bell"></i>
                        <span>الاشعارات</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <button type="button" onclick="logout()" class='sidebar-link btn'>
                        <i class="bi bi-door-open"></i>
                        <span>تسجيل خروج</span>
                    </button>
                </li>

            </ul>
        </div>
        <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
    </div>
</div>

<script> 
    var sidebarItem = "<?=$this->uri->segment(1); ?>";
    if(sidebarItem != ""){
        $(".sidebar-item").removeClass("active");
        $("#"+sidebarItem).addClass("active"); 
    }
</script>