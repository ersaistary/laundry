<?php
if (isset($_GET['delete'])) {
    $id_user = $_GET['delete'];
    $queryDelete = mysqli_query($config, "DELETE FROM user WHERE id = $id_user");
    header("location:?page=user&hapus=" . ($queryDelete ? "berhasil" : "gagal"));
}


if (isset($_GET['edit'])) {
    $id_user = $_GET['edit'];
    $selectEdit = mysqli_query($config, "SELECT * FROM user WHERE id = $id_user");
    $rowEdit = mysqli_fetch_assoc($selectEdit);
}

if (isset($_POST['name'])) {
    $name     = $_POST['name'];
    $email    = $_POST['email'];
    $password = $_POST['password'];
    $level_id = $_POST['id_level'];

    if (isset($_GET['edit'])) {
        $id_user = $_GET['edit'];
        if (!empty($password)) {
            $hashed = sha1($password);
            $sql = "UPDATE user SET name='$name', email='$email', password='$hashed', id_level='$level_id' WHERE id='$id_user'";
        } else {
            $sql = "UPDATE user SET name='$name', email='$email', id_level='$level_id' WHERE id='$id_user'";
        }
        $update = mysqli_query($config, $sql);
        header("location:?page=user&ubah=berhasil");
    } else {
        $hashed = sha1($password);
        $sql = "INSERT INTO user (name, email, password, id_level) VALUES ('$name', '$email', '$hashed', '$level_id')";
        $insert = mysqli_query($config, $sql);
        header("location:?page=user&tambah=berhasil");
    }
}
?>

<div class="col-xxl">
  <div class="card mb-4">
    <div class="card-header d-flex align-items-center">
      <h5 class="mb-0">
        <?= isset($_GET['edit']) ? "Edit User" : "Add User"; ?>
      </h5>
    </div>
    <div class="card-body">
      <form method="POST">
        <div class="row mb-3">
          <label class="col-sm-2 col-form-label">Name</label>
          <div class="col-sm-10">
            <input type="text" name="name" class="form-control" placeholder="John Doe"
              value="<?= isset($rowEdit) ? $rowEdit['name'] : '' ?>" required>
          </div>
        </div>
        <div class="row mb-3">
          <label class="col-sm-2 col-form-label">Email</label>
          <div class="col-sm-10">
            <input type="email" name="email" class="form-control" placeholder="john@example.com"
              value="<?= isset($rowEdit) ? $rowEdit['email'] : '' ?>" required>
          </div>
        </div>
        <div class="row mb-3">
          <label class="col-sm-2 col-form-label">Password</label>
          <div class="col-sm-10">
            <input type="password" name="password" class="form-control"
              placeholder="<?= isset($_GET['edit']) ? 'Leave blank to keep current password' : 'Password' ?>">
          </div>
        </div>
        <div class="row mb-3">
          <label class="col-sm-2 col-form-label">Level</label>
          <div class="col-sm-10">
            <select name="id_level" class="form-control" required>
              <option value="">Select Level</option>
              <?php
              $levels = mysqli_query($config, "SELECT * FROM level WHERE deleted_at IS NULL");
              while ($lvl = mysqli_fetch_assoc($levels)) :
              ?>
              <option value="<?= $lvl['id'] ?>" <?= isset($rowEdit) && $rowEdit['id_level'] == $lvl['id'] ? 'selected' : '' ?>>
                <?= $lvl['level_name'] ?>
              </option>
              <?php endwhile; ?>
            </select>
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
