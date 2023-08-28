<body>@include('layout.header')
    <div class="d-flex justify-content-center align-items-center mt-3">
        <div id="notificationBar" class="toast" role="alert" aria-live="assertive" aria-atomic="true"
            data-bs-autohide="false">
            <div class="toast-header">
                <strong class="me-auto">Notification</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                Item added successfully!
            </div>
        </div>
    </div>
   
    
        <!-- Loading Icon -->
        {{-- <div id="loadingIcon" class="d-flex justify-content-center align-items-center position-fixed vw-100 vh-90 bg-white" style="display: none !important;">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div> --}}
        
      
    


    <div class="container mt-5">
        <h2 class="mb-4">Add Customer</h2>
        <form method="POST" action="save" id="editForm" class="row g-3">
            @csrf

            <div class="col-md-6 mb-3">
                <label for="name" id="" class="form-label">Customer Name<span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter name">
            </div>
            <div class="col-md-6 mb-3">
                <label for="productSelect" class="form-label">Product<span class="text-danger">*</span></label>
                <select id="productSelect" name="product" class="form-select" aria-label="Product select">
                    <option selected>Select Product</option>
                    @foreach ($products as $product)
                        <option value="{{ $product->product_name }}" data-id="{{ $product->product_id }}"
                            data-rate="{{ $product->rate }}" data-unit="{{ $product->unit }}">
                            {{ $product->product_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label for="rate" class="form-label">Rate</label>
                <input type="text" class="form-control-plaintext" id="rate" name="rate" readonly>
            </div>
            <div class="col-md-6 mb-3">
                <label for="unit" class="form-label">Unit</label>
                <input type="text" class="form-control-plaintext" id="unit" name="unit" readonly>
            </div>
            <div class="col-md-6 mb-3">
                <label for="qty" class="form-label">Qty<span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="qty" name="qty" placeholder="Enter qty">
            </div>
            <div class="col-md-6 mb-3">
                <label for="discount" class="form-label">Discount (%)<span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="discount" name="discount" placeholder="Enter discount">
            </div>
            <div class="col-md-6 mb-3">
                <label for="netamount" class="form-label">Net Amount</label>
                <input type="text" class="form-control-plaintext" id="netamount" readonly name="netamount">
            </div>
            <div class="col-md-6 mb-3">
                <label for="totalamount" class="form-label">Total Amount</label>
                <input type="text" class="form-control-plaintext" id="totalamount" readonly name="totalamount">
            </div>

            <div class="col-md-12">
                <div class="text-start">
                    <button type="submit" id="submitButton" class="btn btn-primary">Save</button>
                    <button type="button" id="cancelButton" class="btn btn-secondary">Cancel</button>
                </div>
            </div>
        </form>


        {{-- table --}}
        <table id="orderTable" class="table table-striped table-responsive">
            <thead class="table-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Customer Name</th>
                    <th scope="col">Product</th>
                    <th scope="col">Rate</th>
                    <th scope="col">Unit</th>
                    <th scope="col">Qty</th>
                    <th scope="col">Discount (%)</th>
                    <th scope="col">Net Amount</th>
                    <th scope="col">Total Amount</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
        <div class="d-flex justify-content-end">
            <button id="saveButton" class="btn btn-primary">Submit</button>
        </div>

    </div>

    <script>
        var products = @json($products);

        function deleteRow(button) {
            const row = button.closest('tr');
            row.remove();
            const tableRows = document.querySelectorAll('#orderTable tbody tr');
            if (tableRows.length > 0) {
                saveButton.disabled = false; // Enable the button
            } else {
                saveButton.disabled = true; // Disable the button
            }
        }


        function EditRow(button) {
            const row = button.closest('tr');
            const name = row.cells[1].textContent;
            const product = row.cells[2].textContent;
            const rate = row.cells[3].textContent;
            const unit = row.cells[4].textContent;
            const qty = row.cells[5].textContent;
            const discount = row.cells[6].textContent;
            const netamount = row.cells[7].textContent;
            const totalamount = row.cells[8].textContent;
            const productSelect = document.getElementById('productSelect')
            const nameInput = document.getElementById('name');
            const rateInput = document.getElementById('rate');
            const unitInput = document.getElementById('unit');
            const qtyInput = document.getElementById('qty');
            const discountInput = document.getElementById('discount');
            const netAmountInput = document.getElementById('netamount');
            const totalAmountInput = document.getElementById('totalamount');
            const editForm = document.getElementById('editForm');
            productSelect.value = product;
            nameInput.value = name;
            rateInput.value = rate;
            unitInput.value = unit;
            qtyInput.value = qty;
            discountInput.value = discount;
            netAmountInput.value = netamount;
            totalAmountInput.value = totalamount;
            editForm.dataset.editId = row.getAttribute('data-id');
            submitButton.textContent='Update'
        }
        
        
        document.addEventListener('DOMContentLoaded', function() {
            const productSelect = document.getElementById('productSelect');
            const nameInput = document.getElementById('name');
            const rateInput = document.getElementById('rate');
            const unitInput = document.getElementById('unit');
            const qtyInput = document.getElementById('qty');
            const discountInput = document.getElementById('discount');
            const netAmountInput = document.getElementById('netamount');
            const totalAmountInput = document.getElementById('totalamount');
            const submitButton = document.getElementById('submitButton');
            const saveButton = document.getElementById('saveButton');
            const tableBody = document.querySelector('#orderTable tbody');
            editForm.dataset.editId = '';
            qtyInput.value = 1;
            discountInput.value = 0;
            checkRequiredFields();

            saveButton.addEventListener('click', function() {
                getAllTableRowsData();
            })
            cancelButton.addEventListener('click', function() {
                event.preventDefault();
                productSelect.value = 'Select Product'; // Reset the select to its default value
                nameInput.value = '';
                rateInput.value = '';
                unitInput.value = '';
                qtyInput.value = 1;
                discountInput.value = 0;
                netAmountInput.value = '';
                totalAmountInput.value = '';
                // ... Clear other form fields ...
                checkRequiredFields()
                submitButton.textContent='Save'
            })

            // Event listener for form submission
            submitButton.addEventListener('click', function(event) {
                event.preventDefault();
                const name = nameInput.value;
                const product = productSelect.value;
                const rate = rateInput.value;
                const unit = unitInput.value;
                const qty = qtyInput.value;
                const discount = discountInput.value;
                const netAmount = netAmountInput.value;
                const totalAmount = totalAmountInput.value;
                const editedRow = document.querySelector(`[data-id="${editForm.dataset.editId }"]`);
                if (editForm.dataset.editId.length > 0) {
                    const editedRow = document.querySelector(`tr[data-id="${editForm.dataset.editId}"]`);
                    if (editedRow) {
                        // Update the content of the cells
                        editedRow.cells[1].textContent = name;
                        editedRow.cells[2].textContent = product;
                        editedRow.cells[3].textContent = rate;
                        editedRow.cells[4].textContent = unit;
                        editedRow.cells[5].textContent = qty;
                        editedRow.cells[6].textContent = discount;
                        editedRow.cells[7].textContent = netAmount;
                        editedRow.cells[8].textContent = totalAmount;

                        editedRow.cells[9].innerHTML = `
            <button class="btn btn-primary btn-sm" onclick="EditRow(this)">Edit</button>
            <button class="btn btn-danger btn-sm" onclick="deleteRow(this)">Delete</button>
        `;
                    }
                    // update table
                } else {
                    const newRow = document.createElement('tr');
                    newRow.innerHTML = `
                                        <td>${tableBody.children.length + 1}</td>
                                        <td>${name}</td>
                                        <td>${product}</td>
                                        <td>${rate}</td>
                                        <td>${unit}</td>
                                        <td>${qty}</td>
                                        <td>${discount}</td>
                                        <td>${netAmount}</td>
                                        <td>${totalAmount}</td>
                                        <td>
                                        <button class="btn btn-primary btn-sm" onclick="EditRow(this)">Edit</button>
                                        <button class="btn btn-danger btn-sm" onclick="deleteRow(this)">Delete</button>
                                    </td>
                                    `;
                    newRow.setAttribute('data-id', tableBody.children.length + 1);
                    // Append the new row to the table
                    tableBody.appendChild(newRow);
                    newRow.scrollIntoView({
                        behavior: 'smooth',
                        block: 'end'
                    });
                };
                // Clear form fields
                productSelect.value = 'Select Product'; // Reset the select to its default value
                nameInput.value = '';
                rateInput.value = '';
                unitInput.value = '';
                qtyInput.value = 1;
                discountInput.value = 0;
                netAmountInput.value = '';
                totalAmountInput.value = '';
                editForm.dataset.editId = '';
                checkRequiredFields()
                submitButton.textContent='Save'
            })

            productSelect.addEventListener('change', function() {
                const selectedOption = productSelect.options[productSelect.selectedIndex];
                const selectedRate = selectedOption.getAttribute('data-rate');
                const selectedUnit = selectedOption.getAttribute('data-unit');

                rateInput.value = selectedRate;
                unitInput.value = selectedUnit;
                updateAmounts()
            });
            qtyInput.addEventListener('input', function(event) {
                event.target.value = event.target.value.replace(/[^1-9]/g, '');
            });

            discountInput.addEventListener('input', function(event) {
                event.target.value = event.target.value.replace(/[^0-9]/g, '');
            });

            function updateAmounts() {
                const rate = parseFloat(rateInput.value) || 0;
                const discount = parseFloat(discountInput.value) || 0;
                const qty = parseFloat(qtyInput.value) || 0;
                let netAmount = 0;

                if (qty != 0) {
                    netAmount = rate - (rate * discount / 100);
                }
                const totalAmount = netAmount * qty;

                netAmountInput.value = netAmount.toFixed(2);
                totalAmountInput.value = totalAmount.toFixed(2);
            }

            function checkRequiredFields() {
                const name = nameInput.value;
                const product = productSelect.value;
                const qty = qtyInput.value;
                const discount = discountInput.value;

                if (name && product != 'Select Product' && qty && discount) {
                    submitButton.disabled = false;
                } else {
                    submitButton.disabled = true;
                }
                const tableRows = document.querySelectorAll('#orderTable tbody tr');
                if (tableRows.length > 0) {
                    saveButton.disabled = false; // Enable the button
                } else {
                    saveButton.disabled = true; // Disable the button
                }
            }


            discountInput.addEventListener('input', updateAmounts);
            qtyInput.addEventListener('input',
                updateAmounts);
            nameInput.addEventListener('input', checkRequiredFields);
            productSelect
                .addEventListener('change', checkRequiredFields);
            qtyInput.addEventListener('input',
                checkRequiredFields);
            discountInput.addEventListener('input', checkRequiredFields);
        });

        function getAllTableRowsData() {
            const tableRows = document.querySelectorAll('#orderTable tbody tr');
            const rowDataArray = [];

            tableRows.forEach(row => {
                const selectedProductObject = products.find(product => product.product_name === row.cells[2]
                    .textContent);
                const rowData = {
                    customerName: row.cells[1].textContent,
                    product: row.cells[2].textContent,
                    product_id: selectedProductObject.product_id,
                    rate: row.cells[3].textContent,
                    unit: row.cells[4].textContent,
                    qty: row.cells[5].textContent,
                    discount: row.cells[6].textContent,
                    netAmount: row.cells[7].textContent,
                    totalAmount: row.cells[8].textContent
                };
                rowDataArray.push(rowData);

            });
            const apiEndpoint = 'http://localhost:8000/api/create-invoice';
            const requestBody = {
                invoiceData: rowDataArray
            };
           
                    saveButton.disabled = true; 
                
            fetch(apiEndpoint, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(requestBody)
                })
                .then(response => console.log(response))
                .then(data => {
                    saveButton.disabled = true;
                    const notificationBar = new bootstrap.Toast(document.getElementById('notificationBar'));

                    function showNotification() {
                        notificationBar.show();
                        setTimeout(function() {
                            window.location.reload();
                        }, 2000); // Hide the notification after 2 seconds
                    }
                    showNotification();
                })
                .catch(error => {
                    console.error('Error saving invoice data:', error);
                });
            console.log(rowDataArray);
        }
    </script>
</body>
