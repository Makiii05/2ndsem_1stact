<html>
<head>
    <title>Create Account</title>
    <link rel="stylesheet" href="account.css">
</head>
<body style="font-family: arial;">
    <div id="divInp" align=center>
        <form method=get action=account.php>
            <br><br><b>Account Number</b>
            <br><input type=number name=txtaccount required><br><br>
            <b>Name</b>
            <br><input type=text name=txtname required>
            <br><br><input type=submit value='Add Account'>
        </form>
    </div><br><br>
    <table id="Tbl" cellpadding=0 cellspacing=0 border=0>
        <tr align="center">
            <td>
                <br>
                <table border=1>
                    <tr><th>Delete</th><th>Ledger</th><th>Account No.</th><th>Name</th><th>Balance</th></tr>
                    <?php
                    $conn = new mysqli("localhost", "root", "", "dbactone");

                    if (isset($_GET["txtaccount"])) {
                        $conn->query("insert into tblaccount (fldaccno, fldname) values ('$_GET[txtaccount]','$_GET[txtname]')");
                    } elseif (isset($_GET["txtdel"])) {
                        $conn->query("delete from tblaccount where fldaccno=$_GET[txtdel]");
                        $conn->query("delete from tblledger where fldaccno=$_GET[txtdel]");
                    } 

                    $result = $conn->query("select * from tblaccount");
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr align=center>
                        <td><a href=account.php?txtdel=$row[fldaccno]><input type=button value=X></a></td>
                        <td><a href=ledger.php?txtaccount=$row[fldaccno]&txtname=$row[fldname]><input type=button value=Ledger></a></td>
                        <td>$row[fldaccno]</td>
                        <td>$row[fldname]</td>";
                        
                        $balance = 0;
                        $L_Result = $conn->query("select * from tblledger where fldaccno='$row[fldaccno]'");
                        while ($L_Row = $L_Result->fetch_assoc()) {
                            $balance += $L_Row["flddebit"] - $L_Row["fldcredit"];
                        }

                        echo "<td>$balance</td></tr>";
                    }
                    ?>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
