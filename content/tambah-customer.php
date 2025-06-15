<?php
if (isset($_GET['delete'])) {
    $id_customer = $_GET['delete'];
    $queryDelete = mysqli_query($config, "UPDATE customer SET deleted_at = NOW() WHERE id = $id_customer");
    header("location:?page=customer&hapus=" . ($queryDelete? "berhasil" : "gagal"));
}

if (isset($_GET['edit'])) {
    $id_customer = $_GET['edit'];
    $selectEdit = mysqli_query($config, "SELECT * FROM customer WHERE id = $id_customer");
    $rowEdit = mysqli_fetch_assoc($selectEdit); 
}

if (isset($_POST['customer_name'])) {
    $name    = $_POST['customer_name'];
    $phone   = $_POST['phone'];
    $address = $_POST['address'];

    if (isset($_GET['edit'])) {
        $id_customer = $_GET['edit'];
        $sql = "UPDATE customer SET customer_name='$name', phone='$phone', address='$address' WHERE id='$id_customer'";
        $update = mysqli_query($config, $sql);
        header("location:?page=customer&ubah=berhasil");
    } else {
        $sql = "INSERT INTO customer (customer_name, phone, address) VALUES ('$name', '$phone', '$address')";
        $insert = mysqli_query($config, $sql);
        header("location:?page=customer&tambah=berhasil");
    }
}
?>


<div class="col-xxl">
  <div class="card mb-4">
    <div class="card-header d-flex align-items-center">
      <h5 class="mb-0">
        <?= isset($_GET['edit']) ? "Edit Customer" : "Add Customer"; ?>
      </h5>
    </div>
    <div class="card-body">
      <form method="POST">
        <div class="row mb-3">
          <label class="col-sm-2 col-form-label" for="customer-name">Name</label>
          <div class="col-sm-10">
            <input
              type="text"
              name="customer_name"
              class="form-control"
              id="customer-name"
              placeholder="Customer Name"
              value="<?= isset($rowEdit) ? $rowEdit['customer_name'] : '' ?>"
              required
            />
          </div>
        </div>
        <div class="row mb-3">
          <label class="col-sm-2 col-form-label" for="customer-phone">Phone</label>
          <div class="col-sm-10">
            <input
              type="text"
              name="phone"
              class="form-control"
              id="customer-phone"
              placeholder="0812 3456 7890"
              value="<?= isset($rowEdit) ? $rowEdit['phone'] : '' ?>"
              required
            />
          </div>
        </div>
        <div class="row mb-3">
          <label class="col-sm-2 col-form-label" for="customer-address">Address</label>
          <div class="col-sm-10">
            <textarea
              name="address"
              class="form-control"
              id="customer-address"
              placeholder="Jl. Mawar No. 123"
              required
            ><?= isset($rowEdit) ? $rowEdit['address'] : '' ?></textarea>
          </div>
        </div>
        <div class="row justify-content-end">
          <div class="col-sm-10">
            <button type="submit" class="btn btn-primary">
              <?= isset($_GET['edit']) ? "Update" : "Submit" ?>
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
