<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Invoice - {{ $sale->invoice_number }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10px;
            margin: 0;
            padding: 0;
        }

        .copy-container {
            margin-bottom: 30px;
            page-break-inside: avoid;
        }

        .copy-title {
            text-align: center;
            padding: 8px;
            margin-bottom: 15px;
            font-weight: bold;
            border: 2px solid;
            font-size: 12px;
        }

        .customer-copy .copy-title {
            background-color: #d1fae5;
            border-color: #10b981;
            color: #065f46;
        }

        .system-copy .copy-title {
            background-color: #fef3c7;
            border-color: #f59e0b;
            color: #92400e;
        }

        .invoice-header {
            border-bottom: 2px solid #333;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }

        .company-info {
            float: left;
            width: 50%;
        }

        .company-info h1 {
            font-size: 14px;
            margin: 0 0 5px 0;
        }

        .invoice-info {
            float: right;
            width: 45%;
            text-align: right;
        }

        .invoice-info h2 {
            font-size: 14px;
            margin: 0 0 5px 0;
        }

        .clear {
            clear: both;
        }

        .section {
            margin-bottom: 20px;
        }

        .section-title {
            background-color: #f3f4f6;
            padding: 6px;
            font-weight: bold;
            margin-bottom: 8px;
            font-size: 11px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
            font-size: 9px;
        }

        .table th {
            background-color: #f3f4f6;
            padding: 6px;
            text-align: left;
            border: 1px solid #ddd;
            font-weight: bold;
        }

        .table td {
            padding: 6px;
            border: 1px solid #ddd;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .total-section {
            float: right;
            width: 250px;
            font-size: 10px;
        }

        .signature {
            margin-top: 30px;
            border-top: 1px dashed #333;
            padding-top: 8px;
            font-size: 9px;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 8px;
            color: #666;
        }

        .copy-separator {
            text-align: center;
            margin: 30px 0;
            color: #666;
            font-style: italic;
            font-size: 9px;
            border-top: 1px dashed #ccc;
            padding-top: 10px;
        }

        /* Compact styles for better fitting */
        .compact-table td,
        .compact-table th {
            padding: 4px;
        }

        .no-margin {
            margin: 0;
            padding: 0;
        }

        .small-text {
            font-size: 8px;
        }

        .medicine-name {
            font-size: 9px;
            line-height: 1.2;
        }

        .medicine-name small {
            font-size: 7px;
        }

        /* Print specific styles */
        @media print {
            body {
                margin: 0;
                padding: 0;
            }

            .copy-container {
                margin-bottom: 20px;
                page-break-after: always;
            }

            .copy-container:last-child {
                page-break-after: avoid;
            }

            .copy-separator {
                display: none;
            }
        }
    </style>
</head>

<body>
    <!-- CUSTOMER COPY -->
    <div class="copy-container customer-copy">
        <div class="copy-title">
            CUSTOMER COPY - KEEP THIS FOR YOUR RECORDS
        </div>

        <!-- Header -->
        <div class="invoice-header">
            <div class="company-info">
                <h1 style="color: #f97316;">Pharmacy Management</h1>
                <p class="no-margin">{{ $sale->branch->address ?? 'Address not specified' }}</p>
                <p class="no-margin">Phone: {{ $sale->branch->phone ?? 'N/A' }}</p>
                <p class="no-margin">Email: pharmacy@example.com</p>
            </div>
            <div class="invoice-info">
                <h2 style="color: #333;">INVOICE</h2>
                <p class="no-margin"><strong>Invoice #:</strong> {{ $sale->invoice_number }}</p>
                <p class="no-margin"><strong>Date:</strong> {{ $sale->sale_date->format('d M, Y') }}</p>
                <p class="no-margin"><strong>Time:</strong> {{ $sale->created_at->format('h:i A') }}</p>
                <p class="no-margin"><strong>Status:</strong> {{ ucfirst($sale->status) }}</p>
            </div>
            <div class="clear"></div>
        </div>

        <!-- Customer Info -->
        <div class="section">
            <div class="section-title">Customer Information</div>
            <table style="width: 100%; font-size: 9px;">
                <tr>
                    <td style="width: 50%; vertical-align: top;">
                        <strong>Name:</strong> {{ $sale->customer_name }}<br>
                        <strong>Phone:</strong> {{ $sale->customer_phone ?? 'N/A' }}
                    </td>
                    <td style="width: 50%; vertical-align: top; text-align: right;">
                        <strong>Branch:</strong> {{ $sale->branch->name }}<br>
                        <strong>Sold By:</strong> {{ $sale->user->name ?? 'System' }}
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="padding-top: 5px;">
                        @if ($sale->customer)
                            <strong>Customer ID:</strong> {{ $sale->customer->customer_id }}
                        @endif
                        &nbsp;&nbsp;&nbsp;
                        <strong>Payment Method:</strong> {{ ucfirst($sale->payment_method) }}
                    </td>
                </tr>
            </table>
        </div>

        <!-- Items Table -->
        <div class="section">
            <div class="section-title">Items Details</div>
            <table class="table compact-table">
                <thead>
                    <tr>
                        <th style="width: 5%;">#</th>
                        <th style="width: 35%;">Medicine Name</th>
                        <th style="width: 15%;">Batch</th>
                        <th style="width: 10%;" class="text-center">Qty</th>
                        <th style="width: 15%;" class="text-right">Unit Price</th>
                        <th style="width: 20%;" class="text-right">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sale->items as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td class="medicine-name">
                                {{ $item->medicine->name }}<br>
                                <small>{{ $item->medicine->generic_name }}</small>
                            </td>
                            <td>{{ $item->batch_number }}</td>
                            <td class="text-center">{{ $item->quantity }}</td>
                            <td class="text-right">৳{{ number_format($item->unit_price, 2) }}</td>
                            <td class="text-right">৳{{ number_format($item->total_amount, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Totals -->
        <div class="total-section">
            <table style="width: 100%;">
                <tr>
                    <td><strong>Sub Total:</strong></td>
                    <td class="text-right">৳{{ number_format($sale->sub_total, 2) }}</td>
                </tr>
                @if ($sale->discount > 0)
                    <tr>
                        <td><strong>Discount:</strong></td>
                        <td class="text-right">-৳{{ number_format($sale->discount, 2) }}</td>
                    </tr>
                @endif
                @if ($sale->tax_amount > 0)
                    <tr>
                        <td><strong>Tax:</strong></td>
                        <td class="text-right">৳{{ number_format($sale->tax_amount, 2) }}</td>
                    </tr>
                @endif
                <tr style="border-top: 2px solid #333;">
                    <td><strong>GRAND TOTAL:</strong></td>
                    <td class="text-right"><strong>৳{{ number_format($sale->grand_total, 2) }}</strong></td>
                </tr>
            </table>
        </div>
        <div class="clear"></div>

        <!-- Notes -->
        @if ($sale->notes)
            <div class="section">
                <div class="section-title">Notes</div>
                <p style="font-size: 9px;">{{ $sale->notes }}</p>
            </div>
        @endif

        <!-- Signature -->
        <div class="signature">
            <table style="width: 100%; font-size: 8px;">
                <tr>
                    <td style="width: 50%;">
                        <strong>Customer Signature:</strong><br><br><br>
                        ------------------------
                    </td>
                    <td style="width: 50%; text-align: right;">
                        <strong>Authorized Signature:</strong><br><br><br>
                        -------------------------
                    </td>
                </tr>
            </table>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>Thank you for your business! This invoice is valid only with official stamp and signature.</p>
            <p>Generated on: {{ now()->format('d M, Y h:i A') }}</p>
        </div>
    </div>


    <!-- SYSTEM COPY -->
    <div class="copy-container system-copy">
        <div class="copy-title">
            SYSTEM COPY - FOR PHARMACY RECORDS
        </div>

        <!-- Header -->
        <div class="invoice-header">
            <div class="company-info">
                <h1 style="color: #f97316;">Pharmacy Management</h1>
                <p class="no-margin">{{ $sale->branch->address ?? 'Address not specified' }}</p>
                <p class="no-margin">Phone: {{ $sale->branch->phone ?? 'N/A' }}</p>
                <p class="no-margin">Email: pharmacy@example.com</p>
            </div>
            <div class="invoice-info">
                <h2 style="color: #333;">INVOICE</h2>
                <p class="no-margin"><strong>Invoice #:</strong> {{ $sale->invoice_number }}</p>
                <p class="no-margin"><strong>Date:</strong> {{ $sale->sale_date->format('d M, Y') }}</p>
                <p class="no-margin"><strong>Time:</strong> {{ $sale->created_at->format('h:i A') }}</p>
                <p class="no-margin"><strong>Copy:</strong> System Copy</p>
            </div>
            <div class="clear"></div>
        </div>

        <!-- Customer Info -->
        <div class="section">
            <div class="section-title">Customer Information</div>
            <table style="width: 100%; font-size: 9px;">
                <tr>
                    <td style="width: 50%; vertical-align: top;">
                        <strong>Name:</strong> {{ $sale->customer_name }}<br>
                        <strong>Phone:</strong> {{ $sale->customer_phone ?? 'N/A' }}<br>
                        @if ($sale->customer)
                            <strong>Customer ID:</strong> {{ $sale->customer->customer_id }}
                        @endif
                    </td>
                    <td style="width: 50%; vertical-align: top; text-align: right;">
                        <strong>Branch:</strong> {{ $sale->branch->name }}<br>
                        <strong>Sold By:</strong> {{ $sale->user->name ?? 'System' }}<br>
                        <strong>Payment:</strong> {{ ucfirst($sale->payment_method) }}
                    </td>
                </tr>
            </table>
        </div>

        <!-- Items Table -->
        <div class="section">
            <div class="section-title">Items Details</div>
            <table class="table compact-table">
                <thead>
                    <tr>
                        <th style="width: 3%;">#</th>
                        <th style="width: 25%;">Medicine</th>
                        <th style="width: 8%;">Batch</th>
                        <th style="width: 8%;">Expiry</th>
                        <th style="width: 6%;" class="text-center">Qty</th>
                        <th style="width: 12%;" class="text-right">Unit Price</th>
                        <th style="width: 12%;" class="text-right">Cost Price</th>
                        <th style="width: 12%;" class="text-right">Total</th>
                        <th style="width: 14%;" class="text-right">Profit</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sale->items as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td class="medicine-name">
                                {{ $item->medicine->name }}<br>
                                <small>ID: {{ $item->medicine->id }}</small>
                            </td>
                            <td>{{ $item->batch_number }}</td>
                            <td>{{ $item->expiry_date ? $item->expiry_date->format('M Y') : 'N/A' }}</td>
                            <td class="text-center">{{ $item->quantity }}</td>
                            <td class="text-right">৳{{ number_format($item->unit_price, 2) }}</td>
                            <td class="text-right">৳{{ number_format($item->cost_price, 2) }}</td>
                            <td class="text-right">৳{{ number_format($item->total_amount, 2) }}</td>
                            <td class="text-right">৳{{ number_format($item->profit, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Totals -->
        <div class="total-section">
            <table style="width: 100%; font-size: 9px;">
                <tr>
                    <td><strong>Sub Total:</strong></td>
                    <td class="text-right">৳{{ number_format($sale->sub_total, 2) }}</td>
                </tr>
                @if ($sale->discount > 0)
                    <tr>
                        <td><strong>Discount:</strong></td>
                        <td class="text-right">-৳{{ number_format($sale->discount, 2) }}</td>
                    </tr>
                @endif
                @if ($sale->tax_amount > 0)
                    <tr>
                        <td><strong>Tax:</strong></td>
                        <td class="text-right">৳{{ number_format($sale->tax_amount, 2) }}</td>
                    </tr>
                @endif
                <tr style="border-top: 2px solid #333;">
                    <td><strong>GRAND TOTAL:</strong></td>
                    <td class="text-right"><strong>৳{{ number_format($sale->grand_total, 2) }}</strong></td>
                </tr>
                @if ($sale->total_cost > 0)
                    <tr>
                        <td><strong>Total Cost:</strong></td>
                        <td class="text-right">৳{{ number_format($sale->total_cost, 2) }}</td>
                    </tr>
                @endif
                @if ($sale->total_profit > 0)
                    <tr style="border-top: 1px solid #ccc;">
                        <td><strong>Total Profit:</strong></td>
                        <td class="text-right"><strong>৳{{ number_format($sale->total_profit, 2) }}</strong></td>
                    </tr>
                @endif
            </table>
        </div>
        <div class="clear"></div>

        <!-- System Info -->
        <div class="section">
            <div class="section-title">System Information</div>
            <table style="width: 100%; font-size: 8px;">
                <tr>
                    <td style="width: 50%;">
                        <strong>Sale ID:</strong> {{ $sale->id }}<br>
                        <strong>Created:</strong> {{ $sale->created_at->format('d M, Y h:i A') }}<br>
                        <strong>Updated:</strong> {{ $sale->updated_at->format('d M, Y h:i A') }}
                    </td>
                    <td style="width: 50%; text-align: right;">
                        <strong>Payment Status:</strong> {{ $sale->payment_status ?? 'Paid' }}<br>
                        @if ($sale->payment_reference)
                            <strong>Reference:</strong> {{ $sale->payment_reference }}
                        @endif
                    </td>
                </tr>
            </table>
        </div>

        <!-- Signature -->
        <div class="signature">
            <table style="width: 100%; font-size: 8px;">
                <tr>
                    <td style="width: 50%;">
                        <strong>Cashier Signature:</strong><br>
                        _________________________<br>
                        Name: {{ $sale->user->name ?? 'N/A' }}
                    </td>
                    <td style="width: 50%; text-align: right;">
                        <strong>Manager Signature:</strong><br>
                        _________________________<br>
                        Date: ___________________
                    </td>
                </tr>
            </table>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>For internal use only. Keep this copy for records.</p>
            <p>Generated on: {{ now()->format('d M, Y h:i A') }} | Printed by: {{ Auth::user()->name ?? 'System' }}
            </p>
        </div>
    </div>
</body>

</html>
