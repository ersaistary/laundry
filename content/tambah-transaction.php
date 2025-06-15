<?php
$serviceId = $_GET['service'] ?? null;
$price = 0;
 $customers = mysqli_query($config, "SELECT * FROM customer WHERE deleted_at IS NULL");

if ($serviceId) {
  $getPrice = mysqli_query($config, "SELECT price FROM type_of_service WHERE id = $serviceId");
  $data = mysqli_fetch_assoc($getPrice);
  $price = $data['price'] ?? 0;
}

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

        <!-- Order Date (readonly now) -->
        <div class="row mb-3">
          <label class="col-sm-2 col-form-label">Order Date</label>
          <div class="col-sm-10">
            <input type="date" name="order_date" class="form-control" value="<?= date('Y-m-d') ?>" readonly>
          </div>
        </div>

        <!-- Quantity -->
        <div class="row mb-3">
          <label class="col-sm-2 col-form-label">Quantity (grams)</label>
          <div class="col-sm-10">
            <input type="number" id="qty" name="qty" class="form-control" required>
          </div>
        </div>

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
  const price = <?= $price ?>;
  const qtyInput = document.getElementById('qty');
  const payInput = document.getElementById('order_pay');
  const totalInput = document.getElementById('total');
  const changeInput = document.getElementById('order_change');

  function calculate() {
    const qty = parseFloat(qtyInput.value) || 0;
    const pay = parseFloat(payInput.value) || 0;
    const kilo = qty / 1000;
    const total = Math.round(kilo * price);
    const change = pay - total;

    totalInput.value = total;
    changeInput.value = change >= 0 ? change : 0;
  }

  qtyInput.addEventListener('input', calculate);
  payInput.addEventListener('input', calculate);
</script>
