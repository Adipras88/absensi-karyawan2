<?= $this->extend('layouts/base_employee') ?>

<?= $this->section('content') ?>
    <section>
        <?php if ($report !== null) :  ?>
            <div class="card card-success d-flex align-items-center p-5">
                <span><i class="bi bi-check-circle" style="font-size: 50px; color: green"></i></span>
                <h5 class="text-center">You have reported today's task!</h5>
            </div>
        <?php else :  ?>

        <div class="card">
            <form action="<?php echo base_url(); ?>/user/report/create/submit" method="post">
                <div class="card-body">

                    <!-- Content -->
                    <div class="form-group">
                        <label class="form-label" for="job_type">Job Type <span style="color: red">*</span></label>
                        <select id="job_id" name="job_id" class="form-select" id="basicSelect">
                            <option value="">--please select--</option>
                            <?php foreach ($job as $j) : ?>
                                <option value="<?= $j['jobId'] ?>" <?php if (old('job_id') == $j['jobId']) {
                                    echo 'selected';
                                } ?>><?= $j['type_of_work'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="total">Total <span style="color: red">*</span></label>
                        <input name="total" type="number" class="form-control" required value="<?= old('total') ?>">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="description">Description <span style="color: red">*</span></label>
                        <textarea name="description" class="form-control" rows="8" required><?= old('description') ?></textarea>
                    </div>

                </div>
                <div class="card-footer text-right">
                    <button class="btn btn-secondary" onclick="history.back()">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
        <?php endif; ?>
    </section>
<?= $this->endSection() ?>