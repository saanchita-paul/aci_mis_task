<!DOCTYPE html>
<html>
<head>
    <title>Employee Report</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 8px; border: 1px solid #ddd; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
<h1>Employee Report</h1>
<table>
    <thead>
    <tr>
        <th>Name</th>
        <th>Start Date</th>
        <th>Salary</th>
        <th>Team</th>
        <th>Organization</th>
    </tr>
    </thead>
    <tbody>
    @foreach($employees as $employee)
        <tr>
            <td>{{ $employee->name }}</td>
            <td>{{ $employee->start_date ?? 'N/A' }}</td>
            <td>{{ number_format($employee->salary, 2) }}</td>
            <td>{{ $employee->team->name ?? 'N/A' }}</td>
            <td>{{ $employee->organization->name ?? 'N/A' }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
