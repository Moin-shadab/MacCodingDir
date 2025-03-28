<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['items']) && !empty($_POST['items']) && !empty($_POST['client_name'])) {
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Quotation - AUM Automation Engineering</title>
            <style>
                body {
                    font-family: 'Arial', sans-serif;
                    margin: 0;
                    padding: 0;
                    background-color: #f4f4f4;
                    line-height: 1.5;
                }
                .container {
                    width: 90%;
                    max-width: 1000px;
                    margin: 20px auto;
                    background: #fff;
                    padding: 20px;
                    box-shadow: 0 0 15px rgba(0,0,0,0.1);
                    border-radius: 5px;
                }
                .header {
                    text-align: center;
                    padding-bottom: 20px;
                    border-bottom: 2px solid #007bff;
                }
                .header h1 {
                    margin: 0;
                    font-size: 28px;
                    color: #003087;
                }
                .header p {
                    margin: 5px 0;
                    font-size: 16px;
                    color: #555;
                }
                .details-container {
                    display: flex;
                    justify-content: space-between;
                    margin: 20px 0;
                    font-size: 14px;
                    flex-wrap: wrap;
                }
                .details-box {
                    flex: 1 1 45%;
                    margin: 10px;
                }
                .details-box h3 {
                    margin: 0 0 10px 0;
                    font-size: 16px;
                    color: #003087;
                    background: #e6f0ff;
                    padding: 5px;
                    border-radius: 3px;
                }
                h3 {
                    margin-bottom: 8px;
                }
                table {
                    width: 100%;
                    border-collapse: collapse;
                    margin: 20px 0;
                    font-size: 13px;
                }
                th, td {
                    border: 1px solid #d0d0d0;
                    padding: 8px;
                    text-align: center;
                }
                th {
                    background-color: #003087;
                    color: #fff;
                    font-weight: bold;
                }
                .total-row {
                    background-color: #e9ecef;
                    font-weight: bold;
                }
                .footer {
                    margin-top: 20px;
                    font-size: 12px;
                    color: #333;
                    display: flex;
                    justify-content: space-between;
                    flex-wrap: wrap;
                }
                .bank-details {
                    width: 48%;
                    padding: 10px;
                    background: #f8f9fa;
                    border: 1px solid #e0e0e0;
                    border-radius: 5px;
                }
                .terms {
                    text-align: center;
                    margin-top: 20px;
                    font-size: 12px;
                    color: #666;
                    width: 100%;
                }
                .btn-container {
                    text-align: center;
                    margin-top: 20px;
                }
                .btn {
                    padding: 10px 20px;
                    background-color: #28a745;
                    color: #fff;
                    border: none;
                    border-radius: 5px;
                    cursor: pointer;
                    font-size: 14px;
                }
                .btn:hover {
                    background-color: #218838;
                }
                .page-break {
                    page-break-before: always;
                }
                @media print {
                    .btn-container {
                        display: none;
                    }
                    .container {
                        box-shadow: none;
                        margin: 0;
                        width: 100%;
                    }
                    .page-break {
                        page-break-before: always;
                    }
                }
                @media (max-width: 768px) {
                    .details-box {
                        width: 100%;
                        margin-bottom: 10px;
                    }
                    .bank-details {
                        width: 100%;
                        margin-bottom: 10px;
                    }
                    table {
                        font-size: 12px;
                    }
                }
            </style>
        </head>
        <body>
            <div class="container">
                <div class="header">
                    <h1>AUM Automation Engineering</h1>
                    <p>Quotation | Date: <?= date('d-m-Y') ?></p>
                </div>

                <!-- Company & Client Details Side by Side in a Row -->
                <div class="details-container">
                    <div class="details-box">
                        <h3>Quotation By:</h3>
                        AUM Automation Engineering<br>
                        Address: XXXXX XXXX XXXX XXX XXXX, XXXX, XXXX<br>
                        PIN Code: XXX<br>
                        Phone: +91-94664-XXXXX, +91-85728-XXXXX<br>
                        Email: info___.com
                    </div>
                    <div class="details-box">
                        <h3>Quotation To:</h3>
                        <?= htmlspecialchars($_POST['client_name']) ?><br>
                        Address: <?= htmlspecialchars($_POST['client_address']) ?><br>
                        GSTIN: <?= htmlspecialchars($_POST['client_gst']) ?><br>
                        Phone: <?= htmlspecialchars($_POST['client_phone']) ?>
                    </div>
                </div>

                <!-- Quotation Table -->
                <?php
                $itemsPerPage = 20;
                $items = $_POST['items'];
                $totalItems = count($items);
                $pages = ceil($totalItems / $itemsPerPage);
                $grandTotal = 0;

                // Single table structure with pagination logic inside
                echo '<table>';
                echo '<thead>
                        <tr>
                            <th>Sr No</th>
                            <th>Item Name</th>
                            <th>Qty</th>
                            <th>Unit Price (₹)</th>
                            <th>GST (%)</th>
                            <th>Total Excl. GST (₹)</th>
                            <th>GST Amount (₹)</th>
                            <th>Total Incl. GST (₹)</th>
                        </tr>
                      </thead>';
                echo '<tbody>';

                for ($i = 0; $i < $totalItems; $i++) {
                    // Insert page break before the 21st item (index 20) and ensure it’s not the first item on a page
                    if ($i > 0 && $i % $itemsPerPage == 0) {
                        echo '</tbody></table><div class="page-break"></div><table><thead>
                              <tr>
                                  <th>Sr No</th>
                                  <th>Item Name</th>
                                  <th>Qty</th>
                                  <th>Unit Price (₹)</th>
                                  <th>GST (%)</th>
                                  <th>Total Excl. GST (₹)</th>
                                  <th>GST Amount (₹)</th>
                                  <th>Total Incl. GST (₹)</th>
                              </tr>
                              </thead><tbody>';
                    }

                    $item = $items[$i];
                    $srNo = $i + 1;
                    $itemName = htmlspecialchars($item['name'] ?? 'N/A');
                    $qty = (int) ($item['qty'] ?? 0);
                    $gst = (float) ($item['gst'] ?? 18);
                    $unitPrice = (float) ($item['price'] ?? 0);

                    $totalExclGst = $qty * $unitPrice;
                    $gstAmount = $totalExclGst * ($gst / 100);
                    $totalInclGst = $totalExclGst + $gstAmount;
                    $grandTotal += $totalInclGst;

                    echo "<tr>
                            <td>$srNo</td>
                            <td>$itemName</td>
                            <td>$qty</td>
                            <td>₹" . number_format($unitPrice, 2) . "</td>
                            <td>$gst%</td>
                            <td>₹" . number_format($totalExclGst, 2) . "</td>
                            <td>₹" . number_format($gstAmount, 2) . "</td>
                            <td>₹" . number_format($totalInclGst, 2) . "</td>
                          </tr>";
                }

                echo '</tbody>';
                // Add tfoot only once at the end
                echo '<tfoot>
                        <tr class="total-row">
                            <td colspan="7" style="text-align: right;">Grand Total</td>
                            <td>₹' . number_format($grandTotal, 2) . '</td>
                        </tr>
                      </tfoot>';
                echo '</table>';
                ?>

                <!-- Footer with Bank Details and Terms (only on last page) -->
                <div class="footer">
                    <div class="bank-details">
                        <h3>Bank Details:</h3>
                        Account No: 123456789012<br>
                        IFSC Code: ABCD0001234<br>
                        Bank Name: XYZ Bank<br>
                        Branch: Karnal, Haryana
                    </div>
                    <div class="terms">
                        Prices mentioned are exclusive of taxes, delivery charges, and any other applicable charges, which will be added as per actuals. Prices are subject to change based on market conditions and availability of stock.
                    </div>
                </div>

                <div class="btn-container">
                    <button class="btn" onclick="window.print()">Download as PDF</button>
                </div>
            </div>
        </body>
        </html>
        <?php
        exit();
    } else {
        echo "Error: Please fill in all required fields (client name and at least one item).";
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quotation Generator - AUM AUTOMATION ENGINEERING</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background-color: #f9f9f9; }
        h1, h2 { color: #333; text-align: center; }
        .container { max-width: 1000px; margin: 0 auto; padding: 20px; background: #fff; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        .company-details, .client-details { margin-bottom: 20px; padding: 10px; border: 1px solid #ddd; border-radius: 4px; }
        .company-details h3, .client-details h3 { margin: 0 0 10px; color: #555; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: center; }
        th { background-color: #4CAF50; color: white; }
        input[type="text"], input[type="number"] { width: 100%; padding: 5px; box-sizing: border-box; }
        button { padding: 8px 15px; border: none; border-radius: 4px; cursor: pointer; }
        .add-btn { background-color: #4CAF50; color: white; }
        .delete-btn { background-color: #ff4444; color: white; }
        .submit-btn { background-color: #008CBA; color: white; }
        .total-row { font-weight: bold; background-color: #f2f2f2; }
        .error { color: red; }
    </style>
</head>
<body>
    <div class="container">
        <h1>AUM AUTOMATION ENGINEERING</h1>
        <div class="company-details">
            <h3>Our Details</h3>
            <p>Address: ABC, From State</p>
            <p>PIN Code: 123456</p>
            <p>Phone: 127927927</p>
        </div>

        <h2>Quotation Generator</h2>
        <form method="POST" id="quotationForm">
            <div class="client-details">
                <h3>Client Details</h3>
                <label>Company Name: <input type="text" name="client_name" required></label><br>
                <label>Address: <input type="text" name="client_address" required></label><br>
                <label>GSTIN: <input type="text" name="client_gst" required></label><br>
                <label>Phone: <input type="text" name="client_phone" required></label>
            </div>

            <table id="quotationTable">
                <thead>
                    <tr>
                        <th>Sr No</th>
                        <th>Item Name</th>
                        <th>Qty</th>
                        <th>GST (%)</th>
                        <th>Unit Price (₹)</th>
                        <th>Total Incl. GST (₹)</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="itemsBody">
                    <!-- Initial Row -->
                    <tr>
                        <td>1</td>
                        <td><input type="text" name="items[0][name]" required></td>
                        <td><input type="number" class="qty" name="items[0][qty]" value="1" min="1" required onchange="updatePrice(this.parentElement.parentElement)"></td>
                        <td><input type="number" class="gst" name="items[0][gst]" value="18" min="0" max="100" step="0.01" required onchange="updatePrice(this.parentElement.parentElement)"></td>
                        <td><input type="number" class="price" name="items[0][price]" value="0" min="0" step="0.01" required onchange="updatePrice(this.parentElement.parentElement)"></td>
                        <td class="total">0.00</td>
                        <td><button type="button" class="delete-btn" onclick="deleteRow(this)">Delete</button></td>
                    </tr>
                </tbody>
            </table>
            <button type="button" class="add-btn" onclick="addRow()">+ Add Item</button>
            <h3>Total Amount: ₹<span id="grandTotal">0.00</span></h3>
            <button type="submit" class="submit-btn">Preview</button>
        </form>
    </div>

    <script>
        let rowCount = 1;

        function updatePrice(row) {
            const qty = parseFloat(row.querySelector('.qty').value) || 0;
            const price = parseFloat(row.querySelector('.price').value) || 0;
            const gst = parseFloat(row.querySelector('.gst').value) || 0;
            const totalExclGst = qty * price;
            const gstAmount = totalExclGst * (gst / 100);
            const totalInclGst = totalExclGst + gstAmount;
            row.querySelector('.total').innerText = totalInclGst.toFixed(2);
            updateTotalAmount();
        }

        function updateTotalAmount() {
            let totalAmount = 0;
            document.querySelectorAll('.total').forEach(cell => {
                totalAmount += parseFloat(cell.innerText) || 0;
            });
            document.getElementById('grandTotal').innerText = totalAmount.toFixed(2);
        }

        function addRow() {
            const tbody = document.getElementById('itemsBody');
            const newRow = document.createElement('tr');
            newRow.innerHTML = `
                <td>${rowCount + 1}</td>
                <td><input type="text" name="items[${rowCount}][name]" required></td>
                <td><input type="number" class="qty" name="items[${rowCount}][qty]" value="1" min="1" required onchange="updatePrice(this.parentElement.parentElement)"></td>
                <td><input type="number" class="gst" name="items[${rowCount}][gst]" value="18" min="0" max="100" step="0.01" required onchange="updatePrice(this.parentElement.parentElement)"></td>
                <td><input type="number" class="price" name="items[${rowCount}][price]" value="0" min="0" step="0.01" required onchange="updatePrice(this.parentElement.parentElement)"></td>
                <td class="total">0.00</td>
                <td><button type="button" class="delete-btn" onclick="deleteRow(this)">Delete</button></td>
            `;
            tbody.appendChild(newRow);
            rowCount++;
        }

        function deleteRow(button) {
            const tbody = document.getElementById('itemsBody');
            if (tbody.rows.length > 1) {
                button.parentElement.parentElement.remove();
                updateRowNumbers();
                updateTotalAmount();
            } else {
                alert("Cannot delete the last row.");
            }
        }

        function updateRowNumbers() {
            const rows = document.querySelectorAll('#itemsBody tr');
            rows.forEach((row, index) => {
                row.cells[0].innerText = index + 1;
            });
        }

        document.addEventListener("DOMContentLoaded", function () {
            updatePrice(document.querySelector('#itemsBody tr')); // Initial calculation
        });
    </script>
</body>
</html>