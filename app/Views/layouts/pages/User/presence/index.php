<?= $this->extend('layouts/base_employee') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped" id="table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Sign In</th>
                            <th>Sign Out</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($presence as $p) : ?>
                            <tr>
                                <?php if ($p['created_at']) : ?>
                                    <td><?= date_format(date_create($p['created_at']), 'd M Y') ?></td>
                                <?php else : ?>
                                    <td>-</td>
                                <?php endif; ?>

                                <?php if ($p['signin_at']) : ?>
                                    <td><?= date_format(date_create($p['signin_at']), 'H:i:s') ?></td>
                                <?php else : ?>
                                    <td>-</td>
                                <?php endif; ?>

                                <?php if ($p['signout_at']) : ?>
                                    <td><?= date_format(date_create($p['signout_at']), 'H:i:s') ?></td>
                                <?php else : ?>
                                    <td>-</td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>