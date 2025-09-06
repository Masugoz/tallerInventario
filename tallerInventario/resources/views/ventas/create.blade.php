<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Venta - Inventario</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
            font-size: 2.2em;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #333;
            font-size: 14px;
        }
        select, input {
            width: 100%;
            padding: 12px;
            border: 2px solid #ddd;
            border-radius: 6px;
            font-size: 16px;
            box-sizing: border-box;
            transition: border-color 0.3s ease;
        }
        select:focus, input:focus {
            outline: none;
            border-color: #28a745;
        }
        .btn {
            padding: 12px 25px;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
            border: none;
            cursor: pointer;
            font-size: 16px;
            transition: all 0.3s ease;
            margin-right: 10px;
            display: inline-block;
        }
        .btn-success {
            background-color: #28a745;
            color: white;
        }
        .btn-success:hover {
            background-color: #218838;
        }
        .btn-secondary {
            background-color: #6c757d;
            color: white;
        }
        .btn-secondary:hover {
            background-color: #545b62;
        }
        .btn-primary {
            background-color: #007bff;
            color: white;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .form-actions {
            margin-top: 30px;
            text-align: center;
            padding-top: 20px;
            border-top: 2px solid #f0f0f0;
        }
        .alert {
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 20px;
            font-weight: 500;
        }
        .alert-error {
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
        }
        .alert-warning {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            color: #856404;
        }
        .error-list {
            margin: 0;
            padding-left: 20px;
        }
        .required {
            color: #dc3545;
        }
        .product-info {
            background-color: #e8f5e8;
            padding: 15px;
            border-radius: 6px;
            margin-top: 10px;
            border-left: 4px solid #28a745;
            display: none;
        }
        .stock-display {
            font-weight: bold;
            color: #28a745;
            margin-top: 5px;
        }
        .no-stock {
            color: #dc3545;
        }
        .sale-summary {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 6px;
            margin-top: 20px;
            border: 2px solid #dee2e6;
            display: none;
        }
        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 12px;
            padding: 8px 0;
        }
        .summary-row:last-child {
            margin-bottom: 0;
            font-weight: bold;
            font-size: 18px;
            border-top: 2px solid #dee2e6;
            padding-top: 15px;
            color: #28a745;
        }
        .summary-label {
            font-weight: 500;
        }
        .summary-value {
            font-weight: bold;
        }
        .form-header {
            background-color: #f8f9fa;
            padding: 20px;
            margin: -30px -30px 30px -30px;
            border-radius: 10px 10px 0 0;
            border-bottom: 3px solid #28a745;
        }
        .form-header h1 {
            margin: 0;
            color: #28a745;
        }
        .help-text {
            font-size: 12px;
            color: #666;
            margin-top: 5px;
        }
        #cantidad_vendida {
            font-size: 18px;
            text-align: center;
            font-weight: bold;
        }
        
        @media (max-width: 600px) {
            .container {
                margin: 10px;
                padding: 20px;
            }
            .form-header {
                margin: -20px -20px 20px -20px;
            }
        }
    </style>
    <script>
        function updateSaleInfo() {
            const select = document.getElementById('product_id');
            const cantidadInput = document.getElementById('cantidad_vendida');
            const productInfo = document.getElementById('product-info');
            const summaryDiv = document.getElementById('sale-summary');
            
            if (select.value) {
                const selectedOption = select.options[select.selectedIndex];
                const productName = selectedOption.text.split(' (')[0];
                const stock = parseInt(selectedOption.getAttribute('data-stock'));
                const price