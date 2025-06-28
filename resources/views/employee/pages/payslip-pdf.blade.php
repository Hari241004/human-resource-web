<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Payslip {{ $payroll->start_date->format('Y-m') }}</title>
  <style>
    body { font-family: sans-serif; font-size: 12px; }
    .header { text-align: center; margin-bottom: 20px; }
    table { width: 100%; border-collapse: collapse; }
    table, th, td { border: 1px solid #000; }
    th, td { padding: 8px; }
  </style>
</head>
<body>
  <div class="header">
    <h2>Payslip {{ $payroll->start_date->format('Y-m') }}</h2>
    <p>{{ $payroll->employee->name }}</p>
  </div>

  <table>
    <tr>
      <th>Komponen</th><th>Jumlah (Rp)</th>
    </tr>
    <tr>
      <td>Gaji Pokok</td>
      <td>{{ number_format($payroll->basic_salary,0,',','.') }}</td>
    </tr>
    <tr>
      <td>Total Tunjangan</td>
      <td>{{ number_format($payroll->total_allowances,0,',','.') }}</td>
    </tr>
    <tr>
      <td>Total Potongan</td>
      <td>{{ number_format($payroll->total_deductions,0,',','.') }}</td>
    </tr>
    <tr>
      <td>Total Lembur</td>
      <td>{{ number_format($payroll->overtime_amount,0,',','.') }}</td>
    </tr>
    <tr>
      <th>Total Take Home</th>
      <th>{{ number_format($payroll->net_salary,0,',','.') }}</th>
    </tr>
  </table>
</body>
</html>
