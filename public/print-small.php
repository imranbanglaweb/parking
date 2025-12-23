<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <title>Report Print</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <script language="javascript" type="text/javascript" src="/js/app.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        * {
            color: #000000 !important;
        }
        tbody > tr > td {
            background-color: #e9e9e9;
            border: 1px #000000 solid !important;
            vertical-align: center;
            text-align: center;
            font-size: 16px;
            font-family: sans-serif;
            padding: 2px;
        }

        thead > tr > th {
            background-color: #e9e9e9;
            border: 1px #000000 solid !important;
            vertical-align: center;
            text-align: center;
            font-size: 16px;
            font-family: sans-serif;
            padding: 2px;
        }

        table {
            border-spacing: 0;
        }

        thead {
            display: table-header-group;
        }

        tfoot {
            display: table-footer-group;
        }
        .col-md-4 {
            text-align: left;
            display: inline-block;
            float: left;
        }
    </style>
</head>
<body style="margin-left: 20px;margin-right: 20px;" bgcolor="#ffffff">
<table cellpadding="0" cellspacing="0" border="0" style="width: 100%;">
    <tr>
        <td valign="top" align="left" style="border: transparent !important;">
            <script language="javascript">
                <!--
                window.onerror = scripterror;

                function scripterror() {
                    return true;
                }

                varele1 = window.opener.document.getElementById("<?php echo $_REQUEST['selLayer']; ?>");
                text = varele1.innerHTML;
                document.write(text);
                text = document;
                print(text);
                //-->
            </script>
        </td>
    </tr>
</table>
<script>
    $("#ReportTable").attr("border", "1");
    $("#ReportTable").attr("cellpadding", "3");
    $("#ReportTable").attr("cellspacing", "0");
    $("#ReportTable").attr("style", "border-collapse: collapse");
    $("#ReportTable tr").attr("style", "display: show");
    $("#ReportTableInner").attr("border", "1");
    $("#ReportTableInner").attr("cellpadding", "3");
    $("#ReportTableInner").attr("cellspacing", "0");
    $("#ReportTableInner").attr("style", "border-collapse: collapse");
</script>
</body>
</html>
