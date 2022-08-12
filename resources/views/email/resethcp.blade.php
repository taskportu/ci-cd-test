<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <style>
        #customers {
            font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 25%;
        }

        #customers td, #customers th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        #customers tr:nth-child(even){
            background-color: #f2f2f2;
        }

        #customers tr:hover {
            background-color: #ddd;
            }

        #customers th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #4CAF50;
            color: white;
        }
    </style>
</head>
<body>
    <h4>Reset HCP Details </h4>
    <table id="customers">
        <tbody>
            <tr>
                <td><b>First Name</b></td>
                <td>{{ $member_name }}</td>
                
            </tr>
            <tr>
                <td><b>Email</b></td>
                <td>{{ $member_email }}</td>
            </tr>
            <tr>
                <td><b>Date</b></td>
                <td>{{ date('Y-m-d') }}</td>
            </tr>
            <tr>
                <td><b>All HCP</b></td>
                <td>
                    @php
                        $myArray = array();
                        foreach ($hcp as $hc){
                            $myArray[] = ' '.$hc->hcp;
                        }
                        // endforeach
                    @endphp
                    {{ (!empty($hcp[0]) ? implode(",", $myArray) : 'No HCP') }}
                </td>
            </tr>
        </tbody>
        </table>
</body>
</html>