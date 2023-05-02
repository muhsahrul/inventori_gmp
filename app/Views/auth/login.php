<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" type="image/png" href="<?= base_url(); ?>/assets/img/beaker.png">
    <!-- <link rel="stylesheet" href="<?= base_url() ?>/vendor/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/assets/css/adminlte.min.css"> -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.4/css/all.min.css">
    <title>Login | Inventori Bahan Kimia</title>
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="card card-outline card-primary">
            <div class="card-header text-center ">
                <div class="login-logo mb-0" style="font-size: 1.8rem;">
                    <b>Inventori Bahan Kimia</b>
                </div>
            </div>
            <div class="card-body">
                <?php if (session()->getFlashdata('msg')) { ?>
                    <div class="alert alert-danger"><?= session()->getFlashdata('msg') ?></div>
                <?php }; ?>
                <form action="<?= site_url() ?>login/auth" method="post">
                    <?= csrf_field(); ?>
                    <div class="input-group mb-3">
                        <input type="email" class="form-control <?= ($validation->hasError('email')) ? 'is-invalid' : ''; ?>" name="email" placeholder="Email" value="<?= old('email'); ?>" autocomplete="off" autofocus>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                        <div class="invalid-feedback"><?= $validation->getError('email'); ?></div>
                    </div>
                    <div class="input-group mb-1">
                        <input type="password" class="form-control <?= ($validation->hasError('password')) ? 'is-invalid' : ''; ?>" name="password" id="password" placeholder="Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                        <div class="invalid-feedback"><?= $validation->getError('password'); ?></div>
                    </div>
                    <label class="text-muted font-weight-normal">
                        <input type="checkbox" id="checkbox" class="form-check-inline mb-4 mr-1" name="show_password" id="show_password1" onclick="showHide()" />
                        Tampilkan password
                    </label>
                    <div class="row justify-content-center">
                        <div class="col-6">
                            <button type="submit" class="btn btn-primary btn-block">Login</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- <script src="<?= base_url() ?>/vendor/jquery/jquery.min.js"></script>
    <script src="<?= base_url() ?>/vendor/bootstrap/js/bootstrap.min.js"></script> -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.min.js" integrity="sha384-VHvPCCyXqtD5DqJeNxl2dtTyhF78xXNXdkwX1CZeRusQfRKp+tA7hAShOK/B/fQ2" crossorigin="anonymous"></script>
    <script type="text/javascript">
        window.setTimeout(function() {
            $(".alert").fadeTo(500, 0).slideUp(500, function() {
                $(this).remove();
            });
        }, 3000);

        function showHide() {
            const password = document.getElementById('password');

            if (password.type === 'password') {
                password.setAttribute('type', 'text');
            } else {
                password.setAttribute('type', 'password');
                document.getElementById('checkbox').checked = false;
            }
        }
    </script>
</body>

</html>