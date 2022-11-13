<?= $this->extend("layouts/app") ?>
<?= $this->section("content") ?>
<div class="container-fluid">

    <div class="d-sm-flex flex-column mb-4">
        <h1 class="h3 mb-3 text-gray-800">Job</h1>

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/admin/dashboard">Home</a></li>
                <li class="breadcrumb-item"><a href="/admin/job">Job</a></li>
                <li class="breadcrumb-item active" aria-current="page">Detail</li>
            </ol>
        </nav>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header d-flex align-items-center justify-content-between py-3">
            <h5 class="card-title mb-0 text-gray-900">Detail Job</h5>
        </div>

        <div class="card-body mt-2">
            <form>
                <div class="row">

                    <div class="col-12">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="fullname" class="form-label">Employee <span
                                            style="color: red">*</span></label>
                                    <input disabled name="fullname" class="form-control" id="fullname"
                                        value="<?= $job['fullname'] ?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="type_of_work" class="form-label">Type of Work <span
                                            style="color: red">*</span></label>
                                    <input disabled name="type_of_work" class="form-control" id="type_of_work"
                                        value="<?= $job['type_of_work'] ?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="point" class="form-label">Goals per Day <span
                                            style="color: red">*</span></label>
                                    <input disabled name="point" class="form-control" id="point"
                                        value="<?= $job['point'] ?>">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="description" class="form-label">
                                Description
                                <span style="color: red">*</span>
                            </label>
                            <textarea name="description" id="editor" cols="30" rows="10">
                                <?= $job['description'] ?>
                            </textarea>
                        </div>
                    </div>
                </div>

                <div class="float-end pt-3">
                    <button onclick="history.back()" type="button" class="btn btn-secondary">Back</button>
                    <a href="<?php echo base_url(); ?>/admin/job/edit/<?= $job['jobId'] ?>"
                        class="btn btn-primary">Edit</a>
                </div>

            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
ClassicEditor
    .create(document.querySelector('#editor'))
    .then(editor => {
        console.log(editor);
        editor.enableReadOnlyMode('#editor');
    })
    .catch(error => {
        console.error(error);
    });
</script>
<?= $this->endSection() ?>