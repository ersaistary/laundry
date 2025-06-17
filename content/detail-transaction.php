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

        <!-- Quantity -->
        <!-- <div class="row mb-3">
          <label class="col-sm-2 col-form-label">Quantity (grams)</label>
          <div class="col-sm-10">
            <input type="number" id="qty" name="qty" class="form-control" required>
          </div>
        </div> -->

        <!-- Status -->
        <!-- <div class="row mb-3">
          <label class="col-sm-2 col-form-label">Order Status</label>
          <div class="col-sm-10">
            <select name="order_status" class="form-control" required>
              <option value="0">Berlangsung</option>
              <option value="1">Selesai</option>
            </select>
          </div>
        </div> -->

        <!-- Total (auto from qty / 1000 * price) -->
        <!-- <div class="row mb-3">
          <label class="col-sm-2 col-form-label">Total</label>
          <div class="col-sm-10">
            <input type="number" id="total" name="total" class="form-control" readonly required>
          </div>
        </div> -->

        <!-- Payment -->
        <!-- <div class="row mb-3">
          <label class="col-sm-2 col-form-label">Order Pay</label>
          <div class="col-sm-10">
            <input type="number" id="order_pay" name="order_pay" class="form-control" required>
          </div>
        </div> -->

        <!-- Change -->
        <!-- <div class="row mb-3">
          <label class="col-sm-2 col-form-label">Change</label>
          <div class="col-sm-10">
            <input type="number" id="order_change" name="order_change" class="form-control" readonly required>
          </div>
        </div> -->

        <!-- Notes -->
        <div class="row mb-3">
          <label class="col-sm-2 col-form-label">Notes</label>
          <div class="col-sm-10">
            <textarea name="notes" id="notes" name="notes" class="form-control"></textarea>
          </div>
        </div> 

        <!-- Add Transaction -->
        <div align="right" class="mb-3">
          <button type="button" class="btn btn-primary addTransaction" id="addTransaction">Add Transaction</button>
        </div>
        <div id="container">
          <div class="row mb-3" id="newRow">
            <table id=myTable>
              <thead>
                <tr>
                  <th>Service</th>
                  <th>Quantity</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>
                    <select name="id_service[]" class="service form-control" required>
                      <option value="">Select Service</option>
                      <?php foreach($rowService as $key => $data): ?>
                        <option value="<?= $data['id'] ?>"><?= $data['service_name'] ?></option>
                      <?php endforeach ?>
                    </select>
                  </td>
                  <td>
                    <input type="number" step="any" name="qty[]" class="qty form-control" required>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

        <!-- Submit -->
        <div class="row">
          <div class="col-sm-3 mt-2">
            <button type="submit" class="btn btn-primary" name="submit">Submit Order</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>