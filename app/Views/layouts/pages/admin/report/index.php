<?= $this->extend('layouts/app') ?>

<?= $this->section('content') ?>
    <div class="container-fluid">
        <div class="d-sm-flex flex-column mb-4">
            <h1 class="h3 mb-3 text-gray-800">Report</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/admin/dashboard">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Performances
                    </li>
                </ol>
            </nav>
        </div>

        <?php if (session()->getFlashData('success_performance')) : ?>
            <div class="alert alert-success" role="alert">
                <?php echo session("success_performance") ?>
            </div>
        <?php endif; ?>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="table">
                        <thead>
                        <tr>
                            <th>No.</th>
                            <th>Name</th>
                            <th>Job Type</th>
                            <th>Total</th>
                            <th>Description</th>
                            <th>Date Created</th>
                            <th>Action</th>
                        </tr>
                        </thead>

                        <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($report as $r) : ?>
                            <tr>
                                <td><?= $i++ ?></td>
                                <td><?= $r['fullname'] ?></td>
                                <td><?= $r['type_of_work'] ?></td>
                                <td><?= $r['total'] ?></td>
                                <td><?= (strlen(htmlspecialchars($r['description_report'])) > 13)
                                        ? substr(htmlspecialchars($r['description_report']), 0, 40) . '...'
                                        : htmlspecialchars(
                                            $r['description_report']
                                        ); ?></td>
                                <td><?= date_format(date_create($r['created_report']), 'd M Y H:i') ?></td>
                                <td>
                                    <a class="btn btn-warning btn-sm" href="<?= base_url(); ?>/admin/report/detail/<?= $r['reportId'] ?>"><i class="bi bi-eye-fill"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
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
                "buttons": [
                    'excel',
                ]
            });
        });

        $(".alert").fadeTo(2000, 500).slideUp(500, function() {
            $(".alert").slideUp(500);
        });
    </script>
<?= $this->endSection() ?>