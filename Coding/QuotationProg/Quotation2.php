<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quotation Generator - AUM Automation Engineering</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background-color: #f9f9f9; }
        h1, h2 { color: #333; text-align: center; }
        .container { max-width: 1000px; margin: 0 auto; padding: 20px; background: #fff; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        .company-details, .client-details { margin-bottom: 20px; padding: 10px; border: 1px solid #ddd; border-radius: 4px; }
        .company-details h3, .client-details h3 { margin: 0 0 10px; color: #555; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: center; }
        th { background-color: #003087; color: white; }
        input[type="text"], input[type="number"] { width: 100%; padding: 5px; box-sizing: border-box; }
        button { padding: 8px 15px; border: none; border-radius: 4px; cursor: pointer; }
        .add-btn { background-color: #003087; color: white; }
        .delete-btn { background-color: #ff4444; color: white; }
        .submit-btn { background-color: #28a745; color: white; }
        .total-row { font-weight: bold; background-color: #f2f2f2; }
        .error { color: red; text-align: center; }
    </style> 
    
</head>
<body>
    <div class="container">
        <h1>AUM AUTOMATION ENGINEERING</h1>
        <div class="company-details">
            <h3>Our Details</h3>
            <p>AUM Automation Engineering</p>
            <p>Address: XXXXX XXXX XXXX XXX XXXX, XXXX, XXXX</p>
            <p>PIN Code: XXX</p>
            <p>Phone: +91-94664-XXXXX, +91-85728-XXXXX</p>
            <p>Email: info___.com</p>
        </div>

        <h2>Quotation Generator</h2>
        <form id="quotationForm">
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
                        <th>Total Excl. GST (₹)</th>
                        <th>GST Amount (₹)</th>
                        <th>Total Incl. GST (₹)</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="itemsBody">
                    <tr>
                        <td>1</td>
                        <td><input type="text" name="items[0][name]" required></td>
                        <td><input type="number" class="qty" name="items[0][qty]" value="1" min="1" required onchange="updateRow(this)"></td>
                        <td><input type="number" class="gst" name="items[0][gst]" value="18" min="0" max="100" step="0.01" required onchange="updateRow(this)"></td>
                        <td><input type="number" class="price" name="items[0][price]" value="0" min="0" step="0.01" required onchange="updateRow(this)"></td>
                        <td class="total-excl-gst">0.00</td>
                        <td class="gst-amount">0.00</td>
                        <td class="total-incl-gst">0.00</td>
                        <td><button type="button" class="delete-btn" onclick="deleteRow(this)">Delete</button></td>
                    </tr>
                </tbody>
            </table>
            <button type="button" class="add-btn" onclick="addRow()">+ Add Item</button>
            <h3>Grand Total: ₹<span id="grandTotal">0.00</span></h3>
            <button type="submit" class="submit-btn">Generate PDF</button>
            <p id="error" class="error"></p>
        </form>
    </div>

    <script>
        let rowCount = 1;

        function updateRow(input) {
            const row = input.closest('tr');
            const qty = parseFloat(row.querySelector('.qty').value) || 0;
            const price = parseFloat(row.querySelector('.price').value) || 0;
            const gst = parseFloat(row.querySelector('.gst').value) || 0;

            const totalExclGst = qty * price;
            const gstAmount = totalExclGst * (gst / 100);
            const totalInclGst = totalExclGst + gstAmount;

            row.querySelector('.total-excl-gst').textContent = totalExclGst.toFixed(2);
            row.querySelector('.gst-amount').textContent = gstAmount.toFixed(2);
            row.querySelector('.total-incl-gst').textContent = totalInclGst.toFixed(2);

            updateGrandTotal();
        }

        function updateGrandTotal() {
            let grandTotal = 0;
            document.querySelectorAll('.total-incl-gst').forEach(cell => {
                grandTotal += parseFloat(cell.textContent) || 0;
            });
            document.getElementById('grandTotal').textContent = grandTotal.toFixed(2);
        }

        function addRow() {
            const tbody = document.getElementById('itemsBody');
            const newRow = document.createElement('tr');
            newRow.innerHTML = `
                <td>${rowCount + 1}</td>
                <td><input type="text" name="items[${rowCount}][name]" required></td>
                <td><input type="number" class="qty" name="items[${rowCount}][qty]" value="1" min="1" required onchange="updateRow(this)"></td>
                <td><input type="number" class="gst" name="items[${rowCount}][gst]" value="18" min="0" max="100" step="0.01" required onchange="updateRow(this)"></td>
                <td><input type="number" class="price" name="items[${rowCount}][price]" value="0" min="0" step="0.01" required onchange="updateRow(this)"></td>
                <td class="total-excl-gst">0.00</td>
                <td class="gst-amount">0.00</td>
                <td class="total-incl-gst">0.00</td>
                <td><button type="button" class="delete-btn" onclick="deleteRow(this)">Delete</button></td>
            `;
            tbody.appendChild(newRow);
            rowCount++;
        }

        function deleteRow(button) {
            const tbody = document.getElementById('itemsBody');
            if (tbody.rows.length > 1) {
                button.closest('tr').remove();
                updateRowNumbers();
                updateGrandTotal();
            } else {
                alert("Cannot delete the last row.");
            }
        }

        function updateRowNumbers() {
            const rows = document.querySelectorAll('#itemsBody tr');
            rows.forEach((row, index) => {
                row.cells[0].textContent = index + 1;
            });
        }

        document.getElementById('quotationForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const clientName = formData.get('client_name');
            const items = [];
            document.querySelectorAll('#itemsBody tr').forEach((row, i) => {
                const item = {
                    name: formData.get(`items[${i}][name]`),
                    qty: parseFloat(formData.get(`items[${i}][qty]`) || 0),
                    gst: parseFloat(formData.get(`items[${i}][gst]`) || 18),
                    price: parseFloat(formData.get(`items[${i}][price]`) || 0)
                };
                if (item.name) items.push(item);
            });

            if (!clientName || items.length === 0) {
                document.getElementById('error').textContent = "Error: Please fill in all required fields (client name and at least one item).";
                return;
            }

            document.getElementById('error').textContent = "";
            generatePDF({ clientName, clientAddress: formData.get('client_address'), clientGst: formData.get('client_gst'), clientPhone: formData.get('client_phone'), items });
        });

        document.addEventListener('DOMContentLoaded', () => {
            updateRow(document.querySelector('#itemsBody tr'));
        });

        // Placeholder for Part 2
        // function generatePDF(data) {
        //     console.log("Data to PDF:", data); // Replace with Part 2 logic
        // }
    </script>
</body>
<!-- Replace the placeholder generatePDF function in Part 1 with this script -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.8.2/jspdf.plugin.autotable.min.js"></script>
<script>
    function generatePDF(data) {
        const { clientName, clientAddress, clientGst, clientPhone, items } = data;

        // Step 1: Generate Preview
        const previewContainer = document.getElementById('previewContainer') || document.createElement('div');
        previewContainer.id = 'previewContainer';
        document.body.appendChild(previewContainer);

        const today = new Date().toLocaleDateString('en-GB', { day: '2-digit', month: '2-digit', year: 'numeric' }).split('/').join('-');
        let grandTotal = 0;

        let previewHtml = `
            <div class="container">
                <div class="header">
                    <h1>AUM Automation Engineering</h1>
                    <p>Quotation | Date: ${today}</p>
                </div>
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
                        ${escapeHtml(clientName)}<br>
                        Address: ${escapeHtml(clientAddress)}<br>
                        GSTIN: ${escapeHtml(clientGst)}<br>
                        Phone: ${escapeHtml(clientPhone)}
                    </div>
                </div>
                <table>
                    <thead>
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
                    </thead>
                    <tbody>
        `;

        const itemsPerPage = 20;
        items.forEach((item, i) => {
            if (i > 0 && i % itemsPerPage === 0) {
                previewHtml += `
                    </tbody></table><div class="page-break"></div><table>
                    <thead>
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
                    </thead>
                    <tbody>
                `;
            }

            const srNo = i + 1;
            const totalExclGst = item.qty * item.price;
            const gstAmount = totalExclGst * (item.gst / 100);
            const totalInclGst = totalExclGst + gstAmount;
            grandTotal += totalInclGst;

            previewHtml += `
                <tr>
                    <td>${srNo}</td>
                    <td>${escapeHtml(item.name)}</td>
                    <td>${item.qty}</td>
                    <td>₹${item.price.toFixed(2)}</td>
                    <td>${item.gst}%</td>
                    <td>₹${totalExclGst.toFixed(2)}</td>
                    <td>₹${gstAmount.toFixed(2)}</td>
                    <td>₹${totalInclGst.toFixed(2)}</td>
                </tr>
            `;
        });

        previewHtml += `
                    </tbody>
                    <tfoot>
                        <tr class="total-row">
                            <td colspan="7" style="text-align: right;">Grand Total</td>
                            <td>₹${grandTotal.toFixed(2)}</td>
                        </tr>
                    </tfoot>
                </table>
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
                    <button class="btn" onclick="downloadPDF('${today}', ${JSON.stringify(data).replace(/"/g, '&quot;')})">Download as PDF</button>
                </div>
            </div>
        `;

        previewContainer.innerHTML = `
            <style>
                body { font-family: 'Arial', sans-serif; margin: 0; padding: 0; background-color: #f4f4f4; line-height: 1.5; }
                .container { width: 90%; max-width: 1000px; margin: 20px auto; background: #fff; padding: 20px; box-shadow: 0 0 15px rgba(0,0,0,0.1); border-radius: 5px; }
                .header { text-align: center; padding-bottom: 20px; border-bottom: 2px solid #007bff; }
                .header h1 { margin: 0; font-size: 28px; color: #003087; }
                .header p { margin: 5px 0; font-size: 16px; color: #555; }
                .details-container { display: flex; justify-content: space-between; margin: 20px 0; font-size: 14px; flex-wrap: wrap; }
                .details-box { flex: 1 1 45%; margin: 10px; }
                .details-box h3 { margin: 0 0 10px 0; font-size: 16px; color: #003087; background: #e6f0ff; padding: 5px; border-radius: 3px; }
                h3 { margin-bottom: 8px; }
                table { width: 100%; border-collapse: collapse; margin: 20px 0; font-size: 13px; }
                th, td { border: 1px solid #d0d0d0; padding: 8px; text-align: center; }
                th { background-color: #003087; color: #fff; font-weight: bold; }
                .total-row { background-color: #e9ecef; font-weight: bold; }
                .footer { margin-top: 20px; font-size: 12px; color: #333; display: flex; justify-content: space-between; flex-wrap: wrap; }
                .bank-details { width: 48%; padding: 10px; background: #f8f9fa; border: 1px solid #e0e0e0; border-radius: 5px; }
                .terms { text-align: center; margin-top: 20px; font-size: 12px; color: #666; width: 100%; }
                .btn-container { text-align: center; margin-top: 20px; }
                .btn { padding: 10px 20px; background-color: #28a745; color: #fff; border: none; border-radius: 5px; cursor: pointer; font-size: 14px; }
                .btn:hover { background-color: #218838; }
                .page-break { page-break-before: always; }
                @media print { .btn-container { display: none; } .container { box-shadow: none; margin: 0; width: 100%; } }
                @media (max-width: 768px) { .details-box { width: 100%; margin-bottom: 10px; } .bank-details { width: 100%; margin-bottom: 10px; } table { font-size: 12px; } }
            </style>
            ${previewHtml}
        `;
    }

    function downloadPDF(today, data) {
        console.log("Today = " + today )
        console.log(data)
        return;
        const { clientName, clientAddress, clientGst, clientPhone, items } = data;
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF({
            unit: 'mm',
            format: 'a4',
            orientation: 'portrait'
        });
        const pageWidth = doc.internal.pageSize.getWidth();
        const pageHeight = doc.internal.pageSize.getHeight();
        const margin = 10;
        let y = margin;

        // Header
        doc.setFontSize(20);
        doc.setTextColor(0, 48, 135); // #003087
        doc.text("AUM Automation Engineering", pageWidth / 2, y, { align: "center" });
        y += 8;
        doc.setFontSize(12);
        doc.setTextColor(85, 85, 85); // #555
        doc.text(`Quotation | Date: ${today}`, pageWidth / 2, y, { align: "center" });
        y += 8;
        doc.setLineWidth(0.5);
        doc.setDrawColor(0, 123, 255); // #007bff
        doc.line(margin, y, pageWidth - margin, y);
        y += 8;

        // Company & Client Details
        doc.setFontSize(12);
        doc.setTextColor(0, 48, 135); // #003087
        doc.text("Quotation By:", margin, y);
        doc.setFillColor(230, 240, 255); // #e6f0ff
        doc.rect(margin, y - 4, 40, 6, 'F');
        y += 6;
        doc.setTextColor(51, 51, 51); // #333
        doc.text("AUM Automation Engineering", margin, y);
        y += 5;
        doc.text("Address: XXXXX XXXX XXXX XXX XXXX, XXXX, XXXX", margin, y);
        y += 5;
        doc.text("PIN Code: XXX", margin, y);
        y += 5;
        doc.text("Phone: +91-94664-XXXXX, +91-85728-XXXXX", margin, y);
        y += 5;
        doc.text("Email: info___.com", margin, y);

        const rightX = pageWidth / 2 + margin;
        y = margin + 14;
        doc.setFontSize(12);
        doc.setTextColor(0, 48, 135); // #003087
        doc.text("Quotation To:", rightX, y);
        doc.setFillColor(230, 240, 255); // #e6f0ff
        doc.rect(rightX, y - 4, 40, 6, 'F');
        y += 6;
        doc.setTextColor(51, 51, 51); // #333
        const clientLines = doc.splitTextToSize(escapeHtml(clientName), 80);
        clientLines.forEach(line => {
            doc.text(line, rightX, y);
            y += 5;
        });
        const addressLines = doc.splitTextToSize(`Address: ${escapeHtml(clientAddress)}`, 80);
        addressLines.forEach(line => {
            doc.text(line, rightX, y);
            y += 5;
        });
        doc.text(`GSTIN: ${escapeHtml(clientGst)}`, rightX, y);
        y += 5;
        doc.text(`Phone: ${escapeHtml(clientPhone)}`, rightX, y);
        y += 10;

        // Table
        const itemsPerPage = 20;
        let grandTotal = 0;
        const tableHeaders = ["Sr No", "Item Name", "Qty", "Unit Price (₹)", "GST (%)", "Total Excl. GST (₹)", "GST Amount (₹)", "Total Incl. GST (₹)"];
        let currentPageItems = [];

        items.forEach((item, i) => {
            const srNo = i + 1;
            const totalExclGst = item.qty * item.price;
            const gstAmount = totalExclGst * (item.gst / 100);
            const totalInclGst = totalExclGst + gstAmount;
            grandTotal += totalInclGst;

            const row = [
                srNo,
                escapeHtml(item.name),
                item.qty,
                `₹${item.price.toFixed(2)}`,
                `${item.gst}%`,
                `₹${totalExclGst.toFixed(2)}`,
                `₹${gstAmount.toFixed(2)}`,
                `₹${totalInclGst.toFixed(2)}`
            ];
            currentPageItems.push(row);

            if (currentPageItems.length === itemsPerPage || i === items.length - 1) {
                if (y > pageHeight - (currentPageItems.length * 6 + 30)) {
                    doc.addPage();
                    y = margin;
                }

                doc.autoTable({
                    startY: y,
                    head: [tableHeaders],
                    body: currentPageItems,
                    theme: 'grid',
                    headStyles: { fillColor: [0, 48, 135], textColor: [255, 255, 255], fontStyle: 'bold', fontSize: 10 },
                    bodyStyles: { fontSize: 10, textColor: [51, 51, 51], minCellHeight: 5 },
                    columnStyles: { 1: { cellWidth: 50 } }, // Wider column for Item Name
                    margin: { left: margin, right: margin },
                    styles: { cellPadding: 1.5, lineColor: [208, 208, 208], lineWidth: 0.1 }, // #d0d0d0
                    didDrawPage: function(data) {
                        y = data.cursor.y;
                    }
                });

                currentPageItems = [];
                y += 5;
            }
        });

        // Grand Total
        if (y > pageHeight - 20) {
            doc.addPage();
            y = margin;
        }
        doc.autoTable({
            startY: y,
            body: [['', '', '', '', '', '', 'Grand Total', `₹${grandTotal.toFixed(2)}`]],
            theme: 'grid',
            bodyStyles: { fontSize: 10, fillColor: [233, 236, 239], fontStyle: 'bold', textColor: [51, 51, 51], halign: 'right' }, // #e9ecef
            columnStyles: { 6: { halign: 'right' }, 7: { halign: 'center' } },
            margin: { left: margin, right: margin },
            styles: { cellPadding: 1.5, lineColor: [208, 208, 208], lineWidth: 0.1 }
        });
        y = doc.lastAutoTable.finalY + 10;

        // Footer
        if (y > pageHeight - 40) {
            doc.addPage();
            y = margin;
        }
        doc.setFontSize(10);
        doc.setTextColor(51, 51, 51); // #333
        doc.setFillColor(248, 249, 250); // #f8f9fa
        doc.rect(margin, y - 4, 80, 25, 'F');
        doc.text("Bank Details:", margin, y);
        y += 5;
        doc.text("Account No: 123456789012", margin, y);
        y += 5;
        doc.text("IFSC Code: ABCD0001234", margin, y);
        y += 5;
        doc.text("Bank Name: XYZ Bank", margin, y);
        y += 5;
        doc.text("Branch: Karnal, Haryana", margin, y);
        y += 8;

        doc.setTextColor(102, 102, 102); // #666
        const termsText = "Prices mentioned are exclusive of taxes, delivery charges, and any other applicable charges, which will be added as per actuals. Prices are subject to change based on market conditions and availability of stock.";
        const termsLines = doc.splitTextToSize(termsText, pageWidth - 2 * margin);
        termsLines.forEach(line => {
            if (y > pageHeight - 10) {
                doc.addPage();
                y = margin;
            }
            doc.text(line, pageWidth / 2, y, { align: "center" });
            y += 5;
        });

        // Save PDF
        doc.save(`Quotation_${today}.pdf`);
    }

    function escapeHtml(text) {
    if (!text) return '';
    return text
        .replace(/&/g, '&amp;')  // Correct entity for &
        .replace(/</g, '&lt;')   // Correct entity for <
        .replace(/>/g, '&gt;')   // Correct entity for >
        .replace(/"/g, '&quot;') // Correct entity for "
        .replace(/'/g, '&#39;'); // Correct entity for '
}
</script>
</html>