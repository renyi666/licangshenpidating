<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){

            var startTime                       =   0;
            var endTime                         =   0;
            function ceshi(){
//                var startTime                       =   0;
//                endTime               =   new Date().getTime();
//
//                alert (endTime);
//                exit();
//                var t=((endTime-startTime)/1000);
//              alert  ("t");
                alert("test");
              
            };

            alert("aa");
            setInterval("ceshi()",1000*3);
        })


    </script>
</head>
<body>

</body>
</html>