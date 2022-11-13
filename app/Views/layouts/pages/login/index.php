<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Admin Dashboard</title>
    <link rel="stylesheet" href="assets/css/main/app.css">
    <link rel="stylesheet" href="assets/css/pages/auth.css">
    <link rel="shortcut icon" href="assets/images/logo/favicon.svg" type="image/x-icon">
    <link rel="shortcut icon" href="assets/images/logo/favicon.png" type="image/png">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.2/font/bootstrap-icons.css">
</head>

<body>
    <div id="auth">
        <div class="row h-100">
            <div class="col-lg-5 col-12" style="align-self: center">
                <div id="auth-left">
                    <h1><i class="bi bi-alarm" style="font-size: 40px;"></i> ABSENSI.</h1>

                    <?php if (session()->getFlashData('failed')) : ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo session("failed") ?>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashData('success')) : ?>
                        <div class="alert success alert-success" role="alert">
                            <?php echo session("success") ?>
                        </div>
                    <?php endif; ?>

                    <p class="auth-subtitle mb-5">Log in with your data that the admin entered.</p>

                    <form action="<?php echo base_url(); ?>/login/submit" method="post">
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input name="email" type="text" class="form-control form-control-xl" placeholder="Email">
                            <div class="form-control-icon">
                                <i class="bi bi-person"></i>
                            </div>
                        </div>
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input name="password" type="password" class="form-control form-control-xl" placeholder="Password">
                            <div class="form-control-icon">
                                <i class="bi bi-shield-lock"></i>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block btn-lg shadow-lg mt-5">Log in</button>
                        </button>
                    </form>
                    <div class="text-center mt-5 text-lg fs-4">
                        <p class="text-gray-600">Don't have an account? <a href="/register" class="font-bold">Sign
                                up</a>.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-7 d-none d-lg-block h-100">
                <img src="/assets/images/img-login.jpg" style="width: 100%; height: 100%">
            </div>
        </div>
    </div>
</body>

<script type="text/javascript">
    $(".success").fadeTo(2000, 500).slideUp(500, function () {
        $(".success").slideUp(500);
    });

</script>

</html>