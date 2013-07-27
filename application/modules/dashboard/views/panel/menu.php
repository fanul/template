<?php
//    print_r($page);
//    echo $page['hr/employee'];
$admin = $this->session->userdata('sys_group_name') == 'admin' ? TRUE : FALSE;
?>
<div id="da-main-nav" class="da-button-container">
    <ul>
        <!-- halaman utama -->

        <li class="active">
            <a href="<?php echo base_url(); ?>">
                <!-- Icon Container -->
                <span class="da-nav-icon">
                    <img src="images/icons/black/32/home.png" alt="Dashboard" />
                </span>
                Menu Utama
            </a>
        </li>

        <!-- user system -->

        <?php if ($admin || isset($priv['admin'])) { ?> 
            <li>
                <a href="#">
                    <!-- Icon Container -->
                    <span class="da-nav-icon">
                        <img src="images/icons/black/32/pacman.png" alt="Admnistrator" />
                    </span>
                    Administrator
                </a>
                <ul>
                    <?php if ($admin || isset($page['admin/er'])) { ?>  <li><a href="javascript:loadPage('#da-content-wrap','<?php echo site_url("admin/user") ?>')">User Control</a></li>  <?php } ?>
                    <?php if ($admin || isset($page['admin/group'])) { ?> <li><a href="javascript:loadPage('#da-content-wrap','<?php echo site_url("admin/group") ?>')">Group Control</a></li>  <?php } ?>
                    <?php if ($admin || isset($page['admin/syslog'])) { ?> <li><a href="javascript:loadPage('#da-content-wrap','<?php echo site_url("admin/syslog") ?>')">Log Control</a></li> <?php } ?>
                    <?php if ($admin || isset($page['admin/chart'])) { ?> <li><a href="javascript:loadPage('#da-content-wrap','<?php echo site_url("admin/chart") ?>')">Chart</a></li> <?php } ?>
                </ul>
            </li>
        <?php } ?>


        <!-- user system -->

        <?php if ($admin || isset($priv['hr'])) { ?> 
            <li>
                <a href="#">
                    <!-- Icon Container -->
                    <span class="da-nav-icon">
                        <img src="images/icons/black/32/admin_user.png" alt="Personalia" />
                    </span>
                    Personalia
                </a>
                <ul class="closed">
                    <?php if ($admin || isset($page['hr/employee'])) { ?> <li><a href="javascript:loadPage('#da-content-wrap','<?php echo site_url("hr/employee") ?>')">karyawan</a></li> <?php } ?> 
                    <?php if ($admin || isset($page['hr/work_log'])) { ?> <li><a href="javascript:loadPage('#da-content-wrap','<?php echo site_url("hr/work_log") ?>')">Work Log</a></li> <?php } ?> 
                    <?php if ($admin || isset($page['hr/track_type'])) { ?> <li><a href="javascript:loadPage('#da-content-wrap','<?php echo site_url("hr/track_type") ?>')">Track Type</a></li> <?php } ?>
                </ul>
            </li>
        <?php } ?>

        <?php if ($admin || isset($priv['dc'])) { ?> 
            <li>
                <a href="#">
                    <!-- Icon Container -->
                    <span class="da-nav-icon">
                        <img src="images/icons/black/32/archive.png" alt="Document Control" />
                    </span>
                    Document Control
                </a>
                <ul class="closed">
                    <?php if (($admin || isset($page['dc/browse']))) { ?> <li><a href="javascript:loadPage('#da-content-wrap','<?php echo site_url("dc/browse") ?>')">Browse</a></li> <?php } ?> 
                </ul>
            </li>
        <?php } ?>

        <?php if ($admin || isset($priv['event'])) { ?> 
            <li>
                <a href="#">
                    <!-- Icon Container -->
                    <span class="da-nav-icon">
                        <img src="images/icons/black/32/calendar_today.png" alt="Event" />
                    </span>
                    Event
                </a>
                <ul>
                    <?php if (($admin || isset($page['event/agenda']))) { ?> <li><a href="javascript:loadPage('#da-content-wrap','<?php echo site_url("event/agenda") ?>')">Calendar</a></li> <?php } ?> 
                    <?php if (($admin || isset($page['admin/agenda/manage']))) { ?> <li><a href="javascript:loadPage('#da-content-wrap','<?php echo site_url("event/agenda/manage") ?>')">Kelola Event</a></li> <?php } ?> 
                    <?php if (($admin || isset($page['admin/event_type']))) { ?> <li><a href="javascript:loadPage('#da-content-wrap','<?php echo site_url("event/event_type") ?>')">Event Type</a></li> <?php } ?> 

                </ul>
            </li>
        <?php } ?>

        <?php if ($admin || isset($priv['news'])) { ?> 
            <li>
                <a href="#">
                    <!-- Icon Container -->
                    <span class="da-nav-icon">
                        <img src="images/icons/black/32/book.png" alt="Event" />
                    </span>
                    Berita
                </a>
                <ul class="closed">
                    <?php if (($admin || isset($page['news/news']))) { ?> <li><a href="javascript:loadPage('#da-content-wrap','<?php echo site_url("news/news") ?>')">Pengelola Berita</a></li> <?php } ?> 
                </ul>
            </li>
        <?php } ?>

        <?php if ($admin || isset($priv['option'])) { ?> 
        <li>
            <a href="#">
                <!-- Icon Container -->
                <span class="da-nav-icon">
                    <img src="images/icons/black/32/help.png" alt="Option" />
                </span>
                Option
            </a>
            <ul class="closed">
                <?php if ($admin || isset($page['option/work_shift'])) { ?>  <li><a href="javascript:loadPage('#da-content-wrap','<?php echo site_url("option/work_shift") ?>')">Work Shift</a></li>  <?php } ?>
            </ul>
        </li>
        <?php } ?>

    </ul>
</div>

</div>