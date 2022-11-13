<?= $this->extend('layouts/base_employee') ?>

<?= $this->section('content') ?>
    <section>
        <?php if ($status === 'PENDING') : ?>
            <div class="card card-success d-flex align-items-center p-5 w-100">
                <span><i class="bi bi-info-circle" style="font-size: 50px; color: orange"></i></span>
                <h5 class="text-center">Waiting for admin to check your permission!</h5>
            </div>
        <?php elseif ($status === 'APPROVED') : ?>
            <div class="card card-success d-flex align-items-center p-5 w-100">
                <span><i class="bi bi-check-circle" style="font-size: 50px; color: green"></i></span>
                <h5 class="text-center">Your permission is Approved!</h5>
            </div>
        <?php elseif ($status === 'REJECTED') : ?>
            <div class="card card-success d-flex align-items-center p-5 w-100">
                <span><i class="bi bi-x-circle" style="font-size: 50px; color: red"></i></span>
                <h5 class="text-center">Your permission is Rejected!</h5>
            </div>
        <?php else : ?>
            <div class="card">
                <div class="card-body">
                    <form action="<?php echo base_url(); ?>/user/permission/submit" method="post"
                          enctype="multipart/form-data">
                        <div class="form-group">
                            <label class="form-label" for="category">Category <span style="color: red">*</span></label>
                            <select required name="category"
                                    class="form-select  <?= ($validation->hasError('category') ? 'is-invalid' : '') ?>"
                                    id="basicSelect" value="<?= old('category') ?>">
                                <option value="">--please select--</option>
                                <?php foreach ($category as $e) : ?>
                                    <option value="<?= $e['slug'] ?>"><?= $e['name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback">
                                <?= $validation->getError('category') ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="nik">Reason <span style="color: red">*</span></label>
                            <textarea required name="description"
                                      class="form-control <?= ($validation->hasError('description') ? 'is-invalid' : '') ?>"
                                      placeholder="example: Covid-19"><?= old('description') ?></textarea>
                            <div class="invalid-feedback">
                                <?= $validation->getError('description') ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="user_proof_file">Upload Proof <span
                                        style="color: red">*</span></label>
                            <input required name="user_proof_file"
                                   class="form-control <?= ($validation->hasError('user_proof_file') ? 'is-invalid' : '') ?>"
                                   id="user_proof_file" type="file" accept=".jpg, .jpeg, .png"
                                   value="<?= old('user_proof_file') ?>">
                            <div class="invalid-feedback">
                                <?= $validation->getError('user_proof_file') ?>
                            </div>
                        </div>
                        <div class="mt-4">
                            <a class="btn btn-secondary" href="/user/absent">Cancel</a>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        <?php endif; ?>
    </section>
<?= $this->endSection() ?>