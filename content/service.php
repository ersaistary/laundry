<?php 
$queryUser = mysqli_query($config, "SELECT * FROM type_of_service");
$rowsUser = mysqli_fetch_all($queryUser, MYSQLI_ASSOC);
?>
<!-- Striped Rows -->
<div class="card">
  <h5 class="card-header">Service Data</h5>
  <h5 align="right" class="me-3">
    <a href="?page=tambah-service" class="btn btn-primary mb-3">Add Service</a>
  </h5>
  <div class="table-responsive text-nowrap">
    <table class="table table-striped">
      <thead>
        <tr>
          <th>No</th>
          <th>Service Name</th>
          <th>Price</th>
          <th>Description</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody class="table-border-bottom-0">
        <?php foreach ($rowsUser as $key => $row): ?>
        <tr>
          <td><?= $key + 1 ?></td>
          <td><?= $row['service_name'] ?></td>
          <td><?= $row['price'] ?></td>
          <td><?= $row['description'] ?></td>
          <td>
            <a href="?page=tambah-service&edit=<?= $row['id'] ?>" class="btn btn-primary">Edit</a>
            <a onclick="return confirm('Are you sure you want to delete this service?')" 
               href="?page=tambah-service&delete=<?= $row['id'] ?>" 
               class="btn btn-danger">Delete</a>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
