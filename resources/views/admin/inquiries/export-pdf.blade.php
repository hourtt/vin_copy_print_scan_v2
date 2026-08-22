<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inquiry Log Export</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: DejaVu Sans, Arial, sans-serif;
            font-size: 11px;
            color: #1a1a1a;
            background: #fff;
        }
        .header {
            padding: 18px 24px 14px;
            border-bottom: 2px solid #1D9E75;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }
        .header-title { font-size: 18px; font-weight: 700; color: #0D0D0B; }
        .header-sub { font-size: 10px; color: #6B6B6B; margin-top: 2px; }
        .header-meta { text-align: right; font-size: 10px; color: #6B6B6B; }
        .content { padding: 16px 24px; }
        table { width: 100%; border-collapse: collapse; margin-top: 8px; }
        thead tr { background: #f5f5f4; }
        th {
            padding: 8px 10px;
            text-align: left;
            font-size: 9px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #6B6B6B;
            border-bottom: 1px solid #e4e4e7;
        }
        td {
            padding: 8px 10px;
            border-bottom: 1px solid #f0f0ee;
            vertical-align: top;
            color: #27272a;
        }
        tr:last-child td { border-bottom: none; }
        tr:nth-child(even) td { background: #fafaf9; }
        .name { font-weight: 600; }
        .sub { font-size: 9px; color: #6B6B6B; margin-top: 2px; }
        .badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 9px;
            font-weight: 600;
            background: #e6f5f1;
            color: #1D9E75;
        }
        .footer {
            padding: 10px 24px;
            border-top: 1px solid #e4e4e7;
            font-size: 9px;
            color: #9A9A96;
            text-align: right;
        }
        .empty { text-align: center; padding: 40px; color: #9A9A96; }
    </style>
</head>
<body>
    <div class="header">
        <div>
            <div class="header-title">Inquiry Log</div>
            <div class="header-sub">
                Vin Copy Print Scan V2
                @if($date_from || $date_to)
                    &mdash; {{ $date_from ? 'From: '.$date_from : '' }} {{ $date_to ? ' To: '.$date_to : '' }}
                @endif
            </div>
        </div>
        <div class="header-meta">
            Generated: {{ $generated }}<br>
            Total: {{ $inquiries->count() }} {{ Str::plural('inquiry', $inquiries->count()) }}
        </div>
    </div>

    <div class="content">
        @if($inquiries->isNotEmpty())
            <table>
                <thead>
                    <tr>
                        <th style="width:20%">Customer</th>
                        <th style="width:25%">Product</th>
                        <th style="width:9%">Price</th>
                        <th style="width:13%">Phone</th>
                        <th style="width:18%">Email</th>
                        <th style="width:7%">Lang</th>
                        <th style="width:13%">Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($inquiries as $inquiry)
                        <tr>
                            <td>
                                <div class="name">{{ $inquiry->user_name_snapshot }}</div>
                            </td>
                            <td>{{ $inquiry->product_name_snapshot }}</td>
                            <td>${{ number_format($inquiry->product_price_snapshot, 2) }}</td>
                            <td>{{ $inquiry->user_phone_snapshot ?? '—' }}</td>
                            <td style="font-size:9px">{{ $inquiry->user_email_snapshot }}</td>
                            <td>
                                <span class="badge">
                                    {{ strtoupper($inquiry->language) }}
                                </span>
                            </td>
                            <td>{{ $inquiry->created_at->format('d M Y H:i') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="empty">No inquiries found for the selected period.</p>
        @endif
    </div>

    <div class="footer">
        Vin Copy Print Scan V2 &mdash; Confidential &mdash; {{ $generated }}
    </div>
</body>
</html>
