<html>
<head>
    <title>Export Table to Excel using jQuery</title>

    <style>
        th, td {
            font:14px Verdana;
        }
        table, th, td {
            border:solid 1px #999;
            padding:2px 3px;
            text-align:center;
        }
        th {
            font-weight:bold;
        }
    </style>
</head>

<body>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script src="https://cdn.rawgit.com/rainabba/jquery-table2excel/1.1.0/dist/jquery.table2excel.min.js"></script>

    <table id="empTable">
        <tr>
            <th>ID</th>
                <th>Employee Name</th>
                    <th>Age</th>
        </tr>
        <tr>
            <td>01</td>
                <td>Alpha</td>
                    <td>37</td>
        </tr>
        <tr>
            <td>02</td>
                <td>Bravo</td>
                    <td>29</td>
        </tr>
    </table>

    <button type="submit" class="btn btn-primary" onclick="myfun()">Excel</button>
</body>

<script>
    function myfun()
    {
        $("#empTable").table2excel({
            filename: "Employees.xls"
        });
    }
    
    // $(document).ready(function () {
    //     $("#empTable").table2excel({
    //         filename: "Employees.xls"
    //     });
    // });
</script>
</html>