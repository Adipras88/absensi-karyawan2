<?= $this->extend("layouts/app") ?>
<?= $this->section("content") ?>
<div class="container-fluid">

    <div class="d-sm-flex flex-column mb-4">
        <h1 class="h3 mb-3 text-gray-800">Category</h1>

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/admin/dashboard">Home</a></li>
                <li class="breadcrumb-item"><a href="/admin/category">Category</a></li>
                <li class="breadcrumb-item active" aria-current="page">Detail</li>
            </ol>
        </nav>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header d-flex align-items-center justify-content-between py-3">
            <h5 class="card-title mb-0 text-gray-900">Detail Category</h5>
        </div>

        <div class="card-body mt-2">
            <form>
                <div class="row">

                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label for="name" class="form-label">Name <span style="color: red">*</span></label>
                            <input disabled name="name" class="form-control" id="name" value="<?= $category['name'] ?>">
                        </div>
                    </div>
                </div>

                <div class="float-start pt-3">
                    <a type="button" class="btn btn-secondary" href="/admin/category">Back</a>
                    <a href="<?php echo base_url(); ?>/admin/category/edit/<?= $category['categoryId'] ?>"
                        class="btn btn-primary">Edit</a>
                </div>

            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>