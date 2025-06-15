<?php 
$queryUser = mysqli_query($config, "
    SELECT level.level_name AS level_name, user.*
    FROM user
    LEFT JOIN level ON user.id_level = level.id
");
$rowsUser = mysqli_fetch_all($queryUser, MYSQLI_ASSOC);
?>
<!-- Striped Rows -->
<div class="card">
  <h5 class="card-header">User Data</h5>
  <h5 align="right" class="me-3">
    <a href="?page=tambah-user" class="btn btn-primary mb-3">Add User</a>
  </h5>
  <div class="table-responsive text-nowrap">
    <table class="table table-striped">
      <thead>
        <tr>
          <th>No</th>
          <th>Level</th>
          <th>Name</th>
          <th>Email</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody class="table-border-bottom-0">
        <?php foreach ($rowsUser as $key => $row): ?>
        <tr>
          <td><?= $key + 1 ?></td>
          <td><?= $row['level_name'] ?></td>
          <td><?= $row['name'] ?></td>
          <td><?= $row['email'] ?></td>
          <td>
            <a href="?page=tambah-user&edit=<?= $row['id'] ?>" class="btn btn-primary">Edit</a>
            <a onclick="return confirm('Are you sure you want to delete this user?')" 
               href="?page=tambah-user&delete=<?= $row['id'] ?>" 
               class="btn btn-danger">Delete</a>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
