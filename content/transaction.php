<?php 
    $queryCustomer = mysqli_query($config, 
    "SELECT 
    trans_order.order_code,
    trans_order.order_date,
    trans_order.order_end_date,
    trans_order.order_status,
    trans_order.order_pay,
    trans_order.order_change,
    trans_order.total,
    
    customer.customer_name,
    customer.phone,
    customer.address,
    
    trans_order_detail.qty,
    trans_order_detail.subtotal,
    trans_order_detail.notes AS detail_notes,
    
    type_of_service.service_name,
    type_of_service.price,
    
    trans_laundry_pickup.pickup_date,
    trans_laundry_pickup.notes AS pickup_notes

    FROM trans_order

    LEFT JOIN customer ON trans_order.id_customer = customer.id
    LEFT JOIN trans_order_detail ON trans_order.id = trans_order_detail.id_order
    LEFT JOIN type_of_service ON trans_order_detail.id_service = type_of_service.id
    LEFT JOIN trans_laundry_pickup ON trans_order.id = trans_laundry_pickup.id_order

    WHERE trans_order.deleted_at IS NULL;
    ");
    $rowCustomer = mysqli_fetch_all($queryCustomer, MYSQLI_ASSOC);
?>
<!-- Striped Rows -->
<div class="card">
<h5 class="card-header">Transaction Data</h5>
<h5 align="right" class="me-3">
    <a href="?page=select-service" class="btn btn-primary mb-3" >Add Transaction</a>
</h5>
<div class="table-responsive text-nowrap">
    <table class="table table-striped">
    <thead>
        <tr>
        <th>No</th>
        <th>Customer</th>
        <th>Order Code</th>
        <th>Order Date</th>
        <th>Order Status</th>
        <th>Quantity</th>
        <th>Total</th>
        <th>Action</th>
        </tr>
    </thead>
    <tbody class="table-border-bottom-0">
        <?php foreach ($rowCustomer as $key => $row):?>
            <tr>
                <td><?= $key + 1 ?></td>
                <td><?= $row['customer_name'] ?></td>
                <td><?= $row['order_code'] ?></td>
                <td><?= $row['order_date'] ?></td>
                <td><?= ($row['order_status'] == 0) ? "Transaksi Berhasil" : "Selesai" ?></td>
                <td><?= $row['qty'] ?></td>
                <td>Rp <?= $row['total'] ?></td>
                <td>
                    <a href="?page=detai-order&edit=<?php echo $row['id']?>" class = "btn btn-warning" name="edit">Detail</a>
                    <a href="?page=tambah-order&edit=<?php echo $row['id']?>" class = "btn btn-primary" name="edit">Edit</a>
                    <a onclick="return confirm('Are you sure wanna delete this data?')" href="?page=tambah-customer&delete=<?php echo $row['id']?>" class = "btn btn-danger" name="delete">Delete</a>
                </td>
            </tr>
            <?php endforeach?>
    </tbody>
    </table>
</div>
</div>
<!--/ Striped Rows -->