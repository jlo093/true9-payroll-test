<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payroll Dates Calculator</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .container {
            max-width: 600px;
            margin-top: 50px;
        }
        .result-box {
            margin-top: 20px;
            padding: 15px;
            border-radius: 5px;
            display: none;
        }
        .error-message {
            color: #dc3545;
            margin-top: 10px;
            display: none;
        }
    </style>
</head>
<body>
<div class="container">
    <h2 class="mb-4 text-center">Payroll Dates Calculator</h2>
    <form id="payrollForm">
        <div class="mb-3">
            <label for="year" class="form-label">Year</label>
            <input type="number"
                   class="form-control"
                   id="year"
                   name="year"
                   min="1900"
                   max="2100"
                   placeholder="Enter year (1900-2100)"
                   required>
        </div>

        <div class="mb-3">
            <label for="month" class="form-label">Month</label>
            <select class="form-select" id="month" name="month" required>
                <option value="">Select a month</option>
                @for ($i = 1; $i <= 12; $i++)
                    <option value="{{ $i }}">{{ date('F', mktime(0, 0, 0, $i, 1)) }}</option>
                @endfor
            </select>
        </div>

        <button type="submit" class="btn btn-primary w-100">Calculate Dates</button>
    </form>

    <div id="resultBox" class="result-box bg-light">
        <h5>Results:</h5>
        <p><strong>Payday:</strong> <span id="paydayResult"></span></p>
        <p><strong>Payment Date:</strong> <span id="paymentDateResult"></span></p>
    </div>

    <div id="errorMessage" class="error-message"></div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.getElementById('payrollForm').addEventListener('submit', async function(e) {
        e.preventDefault();

        const year = document.getElementById('year').value;
        const month = document.getElementById('month').value;
        const resultBox = document.getElementById('resultBox');
        const errorMessage = document.getElementById('errorMessage');

        resultBox.style.display = 'none';
        errorMessage.style.display = 'none';

        try {
            const response = await fetch(`/api/payroll/dates?year=${year}&month=${month}`, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json'
                }
            });

            const data = await response.json();

            if (response.ok && data.success) {
                document.getElementById('paydayResult').textContent = data.data.payday;
                document.getElementById('paymentDateResult').textContent = data.data.payment_date;
                resultBox.style.display = 'block';
            } else {
                throw new Error(data.message || 'An error occurred');
            }
        } catch (error) {
            errorMessage.textContent = error.message;
            errorMessage.style.display = 'block';
        }
    });
</script>
</body>
</html>
