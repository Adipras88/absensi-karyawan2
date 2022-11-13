<div class="sidebar-menu">
    <ul class="menu">
        <li class="sidebar-title">Data</li>
        <li class="sidebar-item <?php if ($page == 'dashboard') {
            echo 'active';
        } ?>">
            <a href="/admin/dashboard" class='sidebar-link'>
                <i class="bi bi-grid-fill"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <li class="sidebar-item <?php if ($page == 'employee') {
            echo 'active';
        } ?>">
            <a href="/admin/employee" class='sidebar-link'>
                <i class="bi bi-people"></i>
                <span>Employee</span>
            </a>
        </li>

        <li class="sidebar-item <?php if ($page == 'report') {
            echo 'active';
        } ?>">
            <a href="/admin/report" class='sidebar-link'>
                <i class="bi bi-file-earmark-person"></i>
                <span>Report</span>
            </a>
        </li>

        <li class="sidebar-title">Events</li>
        <li class="sidebar-item <?php if ($page == 'attendance') {
            echo 'active';
        } ?>">
            <a href="/admin/attendance" class='sidebar-link'>
                <i class="bi bi-list-check"></i>
                <span>Attendance</span>
            </a>
        </li>

        <li class="sidebar-item <?php if ($page == 'QR') {
            echo 'active';
        } ?>">
            <a href="/admin/qr" class='sidebar-link'>
                <i class="bi bi-qr-code"></i>
                <span>QR</span>
            </a>
        </li>

        <li class="sidebar-item <?php if ($page == 'evaluation') {
            echo 'active';
        } ?>">
            <a href="/admin/evaluation" class='sidebar-link'>
                <i class="bi bi-graph-up-arrow"></i>
                <span>Evaluation</span>
            </a>
        </li>

        <li class="sidebar-title">Preferences</li>
        <li class="sidebar-item <?php if ($page == 'category') {
            echo 'active';
        } ?>">
            <a href="/admin/category" class='sidebar-link'>
                <i class="bi bi-tags"></i>
                <span>Absence Category</span>
            </a>
        </li>

        <li class="sidebar-item <?php if ($page == 'job') {
            echo 'active';
        } ?>">
            <a href="/admin/job" class='sidebar-link'>
                <i class="bi bi-journal-text"></i>
                <span>Job</span>
            </a>
        </li>

        

        

        <div class="d-grid gap-2">
            <a class='btn btn-outline-danger mt-5' block href="<?php echo base_url(); ?>/logout">
                <i class="bi bi-lock-fill" style="padding-right: 10px"></i>Log Out
            </a>
        </div>
    </ul>
</div>