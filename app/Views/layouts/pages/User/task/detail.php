<?= $this->extend('layouts/base_employee') ?>

<?= $this->section('content') ?>
<section>
    <div class="card">
        <div class="card-header" style="background-color: #435ebe;">
            <h5 style="color: white">Detail Your Task today</h5>
        </div>
        <?php if ($job) : ?>
        <div class="row p-4">
            <div class="col-12 col-md-6">
                <h5>Task</h5>
                <span><?= $job['description'] ?></span>
            </div>
            <div class="col-12 col-md-2">
                <h5>Point</h5>
                <span><?= $job['point'] ?></span>
            </div>
            <div class="col-12 col-md-4">
                <h5>Date Created</h5>
                <span><?= date_format(date_create($job['created_at']), 'd M Y H:i') ?></span>
            </div>
        </div>
        <?php else :  ?>
        <div class="row p-4 text-center">
            <h5>Waiting Task for Today!</h5>
        </div>
        <?php endif ?>
    </div>
</section>
<?= $this->endSection() ?>