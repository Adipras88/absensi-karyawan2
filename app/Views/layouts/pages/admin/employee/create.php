<?= $this->extend("layouts/app") ?>
<?= $this->section("content") ?>
<div class="container-fluid">

    <div class="d-sm-flex flex-column mb-4">
        <h1 class="h3 mb-3 text-gray-800">Employee</h1>

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/admin/dashboard">Home</a></li>
                <li class="breadcrumb-item"><a href="/admin/employee">Employee</a></li>
                <li class="breadcrumb-item active" aria-current="page">Add
                </li>
            </ol>
        </nav>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header d-flex align-items-center justify-content-between py-3">
            <h5 class="card-title mb-0 text-gray-900">Create Employee</h5>
        </div>

        <div class="card-body mt-2">
            <form action="<?php echo base_url(); ?>/admin/employee/save" method="post">
                <?= csrf_field(); ?>
                <div class="row">
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label for="email" class="form-label">Email <span style="color: red">*</span></label>
                            <input name="email" class="form-control <?= ($validation->hasError('email') ? 'is-invalid' : '') ?>" id="email" type="email" placeholder="example: example@gmail.com" value="<?= old('email') ?>">
                            <div class="invalid-feedback">
                                <?= $validation->getError('email') ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="password" class="form-label">Password <span style="color: red">*</span></label>
                            <input name="password" class="form-control <?= ($validation->hasError('password') ? 'is-invalid' : '') ?>" id="password" type="password" placeholder="Input password" value="<?= old('password') ?>">
                            <div class="invalid-feedback">
                                <?= $validation->getError('password') ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="confirmPassword" class="form-label">Confirm Password <span style="color: red">*</span></label>
                            <input name="confirmPassword" class="form-control <?= ($validation->hasError('confirmPassword') ? 'is-invalid' : '') ?>" id="confirmPassword" type="password" placeholder="Input confirm password" value="<?= old('confirmPassword') ?>">
                            <div class="invalid-feedback">
                                <?= $validation->getError('confirmPassword') ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="position" class="form-label">Position <span style="color: red">*</span></label>
                            <input name="position" class="form-control <?= ($validation->hasError('position') ? 'is-invalid' : '') ?>" id="position" value="<?= old('position') ?>" placeholder="example: Programmer">
                            <div class="invalid-feedback">
                                <?= $validation->getError('position') ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label for="fullname" class="form-label">Fullname <span style="color: red">*</span></label>
                            <input name="fullname" class="form-control <?= ($validation->hasError('fullname') ? 'is-invalid' : '') ?>" id="fullname" placeholder="example: brotherhood" value="<?= old('fullname') ?>">
                            <div class="invalid-feedback">
                                <?= $validation->getError('fullname') ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="phone" class="form-label">Phone Number <span style="color: red">*</span></label>
                            <input name="phone_number" class="form-control <?= ($validation->hasError('phone_number') ? 'is-invalid' : '') ?>" id="phone" placeholder="example: 08146635529" value="<?= old('phone_number') ?>">
                            <div class="invalid-feedback">
                                <?= $validation->getError('phone_number') ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="date_of_birth" class="form-label">Date of Birth <span style="color: red">*</span></label>
                            <input name="date_of_birth" class="form-control <?= ($validation->hasError('date_of_birth') ? 'is-invalid' : '') ?>" id="date_of_birth" type="date" value="<?= old('date_of_birth') ?>">
                            <div class="invalid-feedback">
                                <?= $validation->getError('date_of_birth') ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="float-end pt-3">
                    <a type="button" class="btn btn-secondary" href="/admin/employee">Cancel</a>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>

            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script type="text/javascript">
    $(document).ready(function() {
        $('#table').DataTable({
            // "dom": 'QBflrtip',
            "dom": `Q
                <'row mt-3'
                    <'col-sm-12 col-md-4'l>
                    <'col-sm-12 col-md-8'
                        <'row'
                            <'col-sm-12 col-md-9'f>
                            <'col-sm-12 col-md-3'B>
                        >
                    >
                >
                ` +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            "responsive": true,
            "paging": true,
            "ordering": true,
            "info": true,
            "buttons": [{
                text: 'Create',
                action: function(e, dt, node, config) {
                    window.location.href = '/admin/employee/form'
                }
            }]
        });
    });
</script>
<?= $this->endSection() ?>