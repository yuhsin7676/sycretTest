function gendoc(){

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

};