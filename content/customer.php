<?php 
    $queryCustomer = mysqli_query($config, "SELECT * FROM customer WHERE deleted_at IS NULL");
    $rowCustomer = mysqli_fetch_all($queryCustomer, MYSQLI_ASSOC);
?>
<!-- Striped Rows -->
<div class="card">
<h5 class="card-header">Data Customer</h5>
<h5 align="right" class="me-3">
    <a href="?page=tambah-customer" class="btn btn-primary mb-3" >Add Customer</a>
</h5>
<div class="table-responsive text-nowrap">
    <table class="table table-striped">
    <thead>
        <tr>
        <th>No</th>
        <th>Customer Name</th>
        <th>Phone</th>
        <th>Address</th>
        <th>Action</th>
        </tr>
    </thead>
    <tbody class="table-border-bottom-0">
        <?php foreach ($queryCustomer as $key => $row):?>
            <tr>
                <td><?= $key + 1 ?></td>
                <td><?= $row['customer_name'] ?></td>
                <td><?= $row['phone'] ?></td>
                <td><?= $row['address'] ?></td>
                <td>
                    <a href="?page=tambah-customer&edit=<?php echo $row['id']?>" class = "btn btn-primary" name="edit">Edit</a>
                    <a onclick="return confirm('Are you sure wanna delete this data?')" href="?page=tambah-customer&delete=<?php echo $row['id']?>" class = "btn btn-danger" name="delete">Delete</a>
                </td>
            </tr>
            <?php endforeach?>
    </tbody>
    </table>
</div>
</div>
<!--/ Striped Rows -->