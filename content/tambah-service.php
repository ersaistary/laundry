<?php
// Delete operation
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $queryDelete = mysqli_query($config, "DELETE FROM type_of_service WHERE id = $id");
    header("location:?page=service&hapus=" . ($queryDelete ? "berhasil" : "gagal"));
}

// Edit operation: fetch the existing record for editing
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $selectEdit = mysqli_query($config, "SELECT * FROM type_of_service WHERE id = $id");
    $rowEdit = mysqli_fetch_assoc($selectEdit);
}

// Insert/Update operation when the form is submitted
if (isset($_POST['service_name'])) {
    $service_name = $_POST['service_name'];
    $price        = $_POST['price']*1000;
    $description  = $_POST['description'];

    if (isset($_GET['edit'])) {
        $id = $_GET['edit'];
        // Update: change service name, price, description and set the updated_at timestamp
        $sql = "UPDATE type_of_service 
                SET service_name='$service_name', 
                    price='$price', 
                    description='$description', 
                    updated_at=NOW() 
                WHERE id='$id'";
        $update = mysqli_query($config, $sql);
        header("location:?page=service&ubah=berhasil");
    } else {
        // Insert: add a new service and set the created_at timestamp
        $sql = "INSERT INTO type_of_service (service_name, price, description, created_at) 
                VALUES ('$service_name', '$price', '$description', NOW())";
        $insert = mysqli_query($config, $sql);
        header("location:?page=service&tambah=berhasil");
    }
}
?>

<div class="col-xxl">
  <div class="card mb-4">
    <div class="card-header d-flex align-items-center">
      <h5 class="mb-0">
        <?= isset($_GET['edit']) ? "Edit Service" : "Add Service"; ?>
      </h5>
    </div>
    <div class="card-body">
      <form method="POST">
        <div class="row mb-3">
          <label class="col-sm-2 col-form-label">Service Name</label>
          <div class="col-sm-10">
            <input type="text" name="service_name" class="form-control" placeholder="Enter Service Name" 
                   value="<?= isset($rowEdit) ? $rowEdit['service_name'] : '' ?>" 
                   required>
          </div>
        </div>

        <div class="row mb-3">
          <label class="col-sm-2 col-form-label">Price</label>
          <div class="col-sm-10">
            <input type="number" name="price" class="form-control" placeholder="Service Price" step="0.01" 
                   value="<?= isset($rowEdit) ? $rowEdit['price'] : '' ?>" 
                   required>
          </div>
        </div>

        <div class="row mb-3">
          <label class="col-sm-2 col-form-label">Description</label>
          <div class="col-sm-10">
            <textarea name="description" class="form-control" placeholder="Service Description" required><?= isset($rowEdit) ? $rowEdit['description'] : '' ?></textarea>
          </div>
        </div>

        <div class="row justify-content-end">
          <div class="col-sm-10" align="right">
            <button type="submit" class="btn btn-primary">
              <?= isset($_GET['edit']) ? "Update" : "Submit" ?>
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
