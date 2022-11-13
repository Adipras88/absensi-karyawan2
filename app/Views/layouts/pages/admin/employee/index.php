<?= $this->extend('layouts/app') ?>

<?= $this->section('content') ?>
    <div class="container-fluid">

        <div class="d-sm-flex flex-column mb-4">
            <h1 class="h3 mb-3 text-gray-800">Employee</h1>

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/admin/dashboard">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Employee
                    </li>
                </ol>
            </nav>
        </div>

        <?php if (session()->getFlashData('success')) : ?>
            <div class="alert alert-success" role="alert">
                <?php echo session("success") ?>
            </div>
        <?php endif; ?>

        <!-- DataTales -->
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="table">
                        <thead>
                        <tr>
                            <th>No.</th>
                            <th>ID PKL</th>
                            <th>Fullname</th>
                            <th>Email</th>
                            <th>Phone Number</th>
                            <th>Registration Date</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($user as $e) : ?>
                            <tr>
                                <td><?= $i++; ?></td>
                                <td><?= $e['ID_PKL']; ?></td>
                                <td><?= $e['fullname']; ?></td>
                                <td><?= $e['email']; ?></td>
                                <td><?= $e['phone_number']; ?></td>
                                <td><?= date_format(date_create($e['registration_at']), 'd M Y H:i'); ?></td>
                                <td>
<!--                                    <a href="--><?php //echo base_url(); ?><!--/admin/employee/edit/--><?//= $e['userId'] ?><!--"-->
<!--                                       class="btn btn-info btn-sm"><i class="bi bi-pencil-square"></i></a>-->
                                    <a href="<?php echo base_url(); ?>/admin/employee/detail/<?= $e['userId'] ?>"
                                       class="btn btn-warning btn-sm"><i class="bi bi-eye-fill"></i></a>
                                   <button class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                          data-bs-target="#deleteModal<?= $e['userId'] ?>"><i
                                             class="bi bi-trash-fill"></i></button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Modal Delete -->
        <?php foreach ($user as $e) : ?>
            <div class="modal fade" id="deleteModal<?= $e['userId'] ?>" data-bs-backdrop="static" tabindex="-1"
                 aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-body text-center">
                            <h3>Are you sure?</h3>
                            Do you really delete this data?

                            </br>
                            <div class="pt-3">
                                <button type="button" class="btn btn-secondary m-2" data-bs-dismiss="modal">No</button>
                                <form class="d-inline" method="post"
                                      action="<?php echo base_url(); ?>/admin/employee/delete/<?= $e['userId'] ?>">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button type="submit" class="btn btn-danger m-2">Yes</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
    <script type="text/javascript">
        $(document).ready(function () {
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
                "buttons": [
                    'excel',
                    // 'pdf',
                    // {
                    //     text: 'Create',
                    //     action: function (e, dt, node, config) {
                    //         window.location.href = '/admin/employee/form'
                    //     }
                    // }
                ]
            });
        });

        $(".alert").fadeTo(2000, 500).slideUp(500, function () {
            $(".alert").slideUp(500);
        });
    </script>
<?= $this->endSection() ?>