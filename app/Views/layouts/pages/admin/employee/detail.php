<?= $this->extend("layouts/app") ?>
<?= $this->section("content") ?>
    <div class="container-fluid">

        <div class="d-sm-flex flex-column mb-4">
            <h1 class="h3 mb-3 text-gray-800">Employee</h1>

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/admin/dashboard">Home</a></li>
                    <li class="breadcrumb-item"><a href="/admin/employee">Employee</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Detail</li>
                </ol>
            </nav>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header d-flex align-items-center justify-content-between py-3">
                <h5 class="card-title mb-0 text-gray-900">Detail Employee</h5>
            </div>

            <div class="card-body mt-2">
                <form>
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="nik" class="form-label">ID PKL <span style="color: red">*</span></label>
                                <input disabled name="ID_PKL" class="form-control" id="ID_PKL" value="<?= $user['ID_PKL'] ?>">
                            </div>
                            <div class="form-group">
                                <label for="email" class="form-label">Email <span style="color: red">*</span></label>
                                <input disabled name="email" class="form-control" id="email"
                                       value="<?= $user['email'] ?>">
                            </div>
                            <div class="form-group">
                                <label for="phone" class="form-label">Phone Number <span
                                            style="color: red">*</span></label>
                                <input disabled name="phone_number" class="form-control" id="phone"
                                       value="<?= $user['phone_number'] ?>">
                            </div>
                            <div class="form-group">
                                <label for="school_origin" class="form-label">School Origin <span
                                            style="color: red">*</span></label>
                                <input disabled name="school_origin" class="form-control" id="school_origin"
                                       value="<?= $user['school_origin'] ?>">
                            </div>
                        </div>

                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="fullname" class="form-label">Fullname <span
                                            style="color: red">*</span></label>
                                <input disabled name="fullname" class="form-control" id="fullname"
                                       value="<?= $user['fullname'] ?>">
                            </div>
                            <div class="form-group">
                                <label for="date_of_birth" class="form-label">Date of Birth <span
                                            style="color: red">*</span></label>
                                <input disabled name="date_of_birth" class="form-control" id="date_of_birth" type="date"
                                       value="<?= $user['date_of_birth'] ?>">
                            </div>
                            <div class="form-group">
                                <label for="position" class="form-label">Position <span
                                            style="color: red">*</span></label>
                                <input disabled name="position" class="form-control" id="position"
                                       value="<?= $user['position'] ?>">
                            </div>
                            <div class="form-group">
                                <label for="internship_length" class="form-label">Internship Length <span
                                            style="color: red">*</span></label>
                                <input disabled name="internship_length" class="form-control" id="internship_length"
                                       value="<?= $user['internship_length'] ?>">
                            </div>
                        </div>
                    </div>

                    <div class="float-end pt-3">
                        <a type="button" class="btn btn-secondary" href="/admin/employee">Back</a>
                        <a href="<?php echo base_url(); ?>/admin/employee/edit/<?= $user['userId'] ?>"
                           class="btn btn-primary">Edit</a>
                    </div>

                </form>
            </div>
        </div>
    </div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#table').DataTable({
                "responsive": true,
            });
        });
    </script>
<?= $this->endSection() ?>