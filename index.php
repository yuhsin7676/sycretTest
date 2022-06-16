<?php

//$a = 0;
//echo $a;

?>

<script src="jquery-3.3.1.min.js"></script>
<script>

    $.ajax({
        type: "GET",
        url: "https://sycret.ru/service/apigendoc/apigendoc",
        data: {
            "use": "", 
            "text": "", 
            "recordid": 30
        },
        success: function(data)
        {
            console.log(data);
        }
    });

</script>