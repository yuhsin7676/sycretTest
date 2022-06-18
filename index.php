<?php

?>

<script src="jquery-3.3.1.min.js"></script>
<script>

    $.ajax({
        type: "GET",
        url: "https://sycret.ru/service/apigendoc/apigendoc",
        //dataType: "text/html",
        data: {
            //"use": "surname", 
            "text": "_", 
            //"recordid": "001D35F6"
        },
        success: function(data){
            console.log(data);
        }
    });

    var data = {
        "URLTemplate": "https://sycret.ru/service/apigendoc/forma_025u.xml",
        "RecordID": 31
    }
    data = JSON.stringify(data);

    $.ajax({
        type: "GET",
        url: "/gendoc",
        data: {
            params: data
        },
        success: function(data){
            data = JSON.parse(data);
            document.location.href = "/generate/" + data.URLWord;
        }
    });

</script>