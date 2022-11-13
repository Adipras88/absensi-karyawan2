<?= $this->extend('layouts/base_employee') ?>

<?= $this->section('content') ?>
<section>
    <div class="text-center">
        <h5 style="color: gray">List Your Task today!</h5>
    </div>
</section>

<section>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped" id="table">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Task</th>
                            <th>Point</th>
                            <th>Date Created</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1 ?>
                        <?php foreach ($job as $j) : ?>
                            <tr>
                                <td><?= $i++ ?></td>
                                <td><?= (strlen(htmlspecialchars($j['description'])) > 13)
                                        ? substr(htmlspecialchars($j['description']), 0, 10) . '...'
                                        : htmlspecialchars(
                                            $j['description']
                                        ); ?>
                                </td>
                                <td><?= $j['point'] ?></td>
                                <td><?= date_format(date_create($j['created_at']), 'd M Y H:i') ?></td>
                                <td>
                                    <a class="btn btn-warning btn-sm" href="<?= base_url() ?>/user/task/detail/<?= $j['jobId'] ?>"><i class="bi bi-eye-fill"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script type="text/javascript">
    $(document).ready(function() {
        $('#table').DataTable({
            "responsive": true,
        });
    });
</script>
<?= $this->endSection() ?>