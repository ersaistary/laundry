<?php
// $serviceId = $_GET['service'] ?? null;
$price = 0;
 $customers = mysqli_query($config, "SELECT * FROM customer WHERE deleted_at IS NULL");

// if ($serviceId) {
//   $getPrice = mysqli_query($config, "SELECT price FROM type_of_service WHERE id = $serviceId");
//   $data = mysqli_fetch_assoc($getPrice);
//   $price = $data['price'] ?? 0;
// }

if(isset($_POST['submit'])){
    // ambil order kode terakhir
    $orderKode = mysqli_query($config, "SELECT order_code from trans_order WHERE order_code LIKE 'ord%' ORDER BY id DESC LIMIT 1");
    $rowOrderCode= mysqli_fetch_assoc($orderKode);
    $lastNum = 0;
    if ($rowOrderCode && isset($rowOrderCode['order_code'])) {
        $lastNum = intval(substr($rowOrderCode['order_code'], 3)); // Strip "ord"
    }
    $nextCode= 'ord' . ($lastNum + 1); 

    $id_customer = $_POST['id_customer'];
    $order_date = $_POST['order_date'];
    $qty = $_POST ['qty'];
    $order_status= $_POST ['order_status'];
    $total = $_POST['total'];
    $order_pay = $_POST['order_pay'];
    $order_change = $_POST['order_change'];

    $insertTransOrder = mysqli_query($config, "INSERT INTO trans_order( id_customer, order_code, order_date, order_status, order_pay, order_change, total) VALUES ('$id_customer','$nextCode','$order_date', '$order_status','$order_pay','$order_change', '$total')");
}

if(isset($_GET['check'])){
  $id_user = $_GET['check'];
  $selectEdit = mysqli_query($config, "SELECT * FROM trans_order WHERE id = $id_user");
  $rowEdit = mysqli_fetch_assoc($selectEdit);
  $queryEdit = mysqli_query ($config, "UPDATE `trans_order` SET `order_end_date`= NOW(),`order_status`= 1 WHERE id = $id_user");
  header ("location=?page=transaction");
}

$queryService=mysqli_query($config, "SELECT * FROM type_of_service WHERE deleted_at IS NULL");
$rowService=mysqli_fetch_all($queryService, MYSQLI_ASSOC);
?>

<div class="col-xxl">
  <div class="card mb-4">
    <div class="card-header">
      <h5 class="mb-0">New Transaction</h5>
    </div>
    <div class="card-body">
      <form method="POST">
        <!-- Customer Select Dropdown -->
        <div class="row mb-3">
        <label class="col-sm-2 col-form-label">Customer</label>
        <div class="col-sm-10">
            <select name="id_customer" class="form-control" required>
            <option value="">Select Customer</option>
            <?php
            while ($cust = mysqli_fetch_assoc($customers)) :
            ?>
                <option value="<?= $cust['id'] ?>"
                <?= (isset($rowEdit) && $rowEdit['id_customer'] == $cust['id']) ? 'selected' : '' ?>>
                <?= $cust['customer_name'] ?> - <?= $cust['phone'] ?>
                </option>
            <?php endwhile; ?>
            </select>
        </div>
        </div>

        <!-- Order Date -->
        <div class="row mb-3">
          <label class="col-sm-2 col-form-label">Order Date</label>
          <div class="col-sm-10">
            <input type="date" name="order_date" class="form-control" value="<?= date('Y-m-d') ?>" readonly>
          </div>
        </div>

        <!-- Quantity
        <div class="row mb-3">
          <label class="col-sm-2 col-form-label">Quantity (grams)</label>
          <div class="col-sm-10">
            <input type="number" id="qty" name="qty" class="form-control" required>
          </div>
        </div> -->

        <!-- Status -->
        <div class="row mb-3">
          <label class="col-sm-2 col-form-label">Order Status</label>
          <div class="col-sm-10">
            <select name="order_status" class="form-control" required>
              <option value="0">Berlangsung</option>
              <option value="1">Selesai</option>
            </select>
          </div>
        </div>

        <!-- Total (auto from qty / 1000 * price) -->
        <div class="row mb-3">
          <label class="col-sm-2 col-form-label">Total</label>
          <div class="col-sm-10">
            <input type="number" id="total" name="total" class="form-control" readonly required>
          </div>
        </div>

        <!-- Payment -->
        <div class="row mb-3">
          <label class="col-sm-2 col-form-label">Order Pay</label>
          <div class="col-sm-10">
            <input type="number" id="order_pay" name="order_pay" class="form-control" required>
          </div>
        </div>

        <!-- Change -->
        <div class="row mb-3">
          <label class="col-sm-2 col-form-label">Change</label>
          <div class="col-sm-10">
            <input type="number" id="order_change" name="order_change" class="form-control" readonly required>
          </div>
        </div>

        <!-- Add Transaction -->
        <div align="right" class="mb-3">
          <button type="button" class="btn btn-primary addTransaction" id="addTransaction">Add Transaction</button>
        </div>
        <div id="container">
          <div class="row mb-3" id="newRow">
            <label class="col-sm-1 col-form-label">Service</label>
            <div class="col-sm-5">
              <select name="service" id="service" class="form-control" required>
                <option value="">Select Service</option>
                <?php foreach($rowService as $key => $data):?>
                  <option value="<?= $data['price']?>"><?= $data['service_name']?></option>
                <?php endforeach?>
              </select>
            </div>
            <label class="col-sm-1 col-form-label">Quantity (Kilo Grams)</label>
            <div class="col-sm-5">
              <input type="number" id="qty" name="qty" class="form-control" required>
            </div>
          </div>
        </div>

        <!-- Submit -->
        <div class="row justify-content-end">
          <div class="col-sm-10">
            <button type="submit" class="btn btn-primary" name="submit">Submit Order</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- JS to Auto Calculate -->
<script>
  const button = document.getElementById('addTransaction');
  const container = document.getElementById('container');
  const templateRow = document.getElementById('newRow');

  button.addEventListener('click', function() {
        const newRow = templateRow.cloneNode(true);
        container.appendChild(newRow);
    });

  const price = document.getElementById('service');
  const qtyInput = document.getElementById('qty');
  const payInput = document.getElementById('order_pay');
  const totalInput = document.getElementById('total');
  const changeInput = document.getElementById('order_change');

  function calculate() {
    const qty = parseFloat(qtyInput.value) || 0;
    const pay = parseFloat(payInput.value) || 0;
    const servicePrice = parseFloat(price.value) || 0;
    const kilo = qty / 1000;
    const total = Math.round(kilo * servicePrice);
    const change = pay - total;

    totalInput.value = total;
    changeInput.value = change >= 0 ? change : 0;
  }

  qtyInput.addEventListener('input', calculate);
  payInput.addEventListener('input', calculate);
</script>
