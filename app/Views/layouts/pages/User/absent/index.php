<?= $this->extend('layouts/base_employee') ?>

<?= $this->section('content') ?>
<section>
    <div class="text-center">
        <span style="color: gray">Please select your Attendance today!</span>
    </div>
</section>

<?php if (session()->getFlashData('success_absent')) : ?>
    <div class="alert alert-success" role="alert">
        <?php echo session("success_absent") ?>
    </div>
<?php endif; ?>

<section>
    <div class="row">
        <?php if ($isLoggedIn === null) : ?>
            <a class="card card-menu stretched-link text-decoration-none" href="/user/scan">
                <div class="card-body text-center">
                    <div class="column justify-content-center">
                        <i class="bi bi-qr-code-scan mt-1 mr-3" style="font-size: 32px; color: #6610f2"></i>
                        <h5 class="title text-center m-0 pt-3" style="color: #5e5e5e">Presence</h5>
                    </div>
                </div>
            </a>
        <?php else : ?>
            <a class="card card-menu stretched-link text-decoration-none" onclick="isLoggedIn()">
                <div class="card-body text-center">
                    <div class="column justify-content-center">
                        <i class="bi bi-qr-code-scan mt-1 mr-3" style="font-size: 32px; color: #6610f2"></i>
                        <h5 class="title text-center m-0 pt-3" style="color: #5e5e5e">Presence</h5>
                    </div>
                </div>
            </a>
        <?php endif; ?>
    </div>

    <div class="row mt-4">
        <a class="card card-menu stretched-link text-decoration-none" href="/user/permission">
            <div class="card-body text-center">
                <div class="column justify-content-center">
                    <i class="bi bi-file-earmark-text mt-1 mr-3" style="font-size: 32px; color: #6610f2"></i>
                    <h5 class="title text-center m-0 pt-3" style="color: #5e5e5e">Permission</h5>
                </div>
            </div>
        </a>
    </div>

    <div class="row mt-4">
        <a class="card card-menu stretched-link text-decoration-none" href="/user/qrcode">
            <div class="card-body text-center">
                <div class="column justify-content-center">
                    <i class="bi bi-qr-code mt-1 mr-3" style="font-size: 32px; color: #6610f2"></i>
                    <h5 class="title text-center m-0 pt-3" style="color: #5e5e5e">QR Code</h5>
                </div>
            </div>
        </a>
    </div>
</section>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    function isLoggedIn() {
        Swal.fire({
            icon: 'info',
            title: 'FYI!',
            text: 'You are absent today!',
            showConfirmButton: false,
            timer: 3500,
            heightAuto: false,
        })
    }

    $(".alert").fadeTo(2000, 500).slideUp(500, function () {
        $(".alert").slideUp(500);
    });
</script>
<?= $this->endSection() ?>
