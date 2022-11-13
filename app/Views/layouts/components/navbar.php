<header>
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="/user" style="color: #25396f;"><i class="bi bi-alarm" style="font-size: 26px;"></i> <span style="font-size: 26px; font-weight: bold">Absensi.</span></a>
            <div class="justify-content-end">
                <div class="dropdown">
                    <button class="btn btn-link dropdown-toggle p-0" style="display: flex; align-items: center; text-decoration: none;" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                        <h5 style="font-size: 16px; margin: 0"><?= session()->get('fullname') ?></h5>
                    </button>
                    <ul class="dropdown-menu p-0" style="min-width: 7rem" aria-labelledby="dropdownMenuButton1">
                        <li><a class="dropdown-item" href="<?php echo base_url(); ?>/user/profile">Profile</a></li>
                        <li><a class="dropdown-item" href="<?php echo base_url(); ?>/logout">Logout</a></li>
                    </ul>
                </div>
                <span style="font-size: 14px; color: gray; margin: 0"><?= session()->get('position') ?></span>
            </div>
        </div>
    </nav>
</header>