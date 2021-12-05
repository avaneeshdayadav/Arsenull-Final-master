<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>Experimental Page</title>
    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
</head>
<body>

<h1>Experiment JSON</h1>

<script type="text/javascript">
    
    $(document).ready(function(){
        $.ajax({
            url: "test_draft_data.php",
            type: 'POST',
            data: {'testId':"12"},
            dataType: "json",
            async:true,
            success:function(data)
            {
                alert(data.id);
                alert(data.name);
            },
            error: function (jqXhr, textStatus, errorMessage)
            { 
                alert(errorMessage);
            }
        });
    });

[
    [
        {"id":"1","testId":"1","unit":"Section 1","question":"New qn?","opa":"Good","opb":null,"opc":null,"opd":null,"correctAnswers":null,"qnImg":null,"opa_img":null,"opb_img":null,"opc_img":null,"opd_img":null,"qnType":null,"noOfcumplQn":null,"qnIdentityNo":"1","secIdentityNo":"1"},
        {"id":"2","testId":"1","unit":null,"question":"This is second qn sec 1","opa":null,"opb":null,"opc":null,"opd":null,"correctAnswers":null,"qnImg":null,"opa_img":null,"opb_img":null,"opc_img":null,"opd_img":null,"qnType":null,"noOfcumplQn":null,"qnIdentityNo":"2","secIdentityNo":"1"}
    ],
    [
        {"id":"3","testId":"1","unit":null,"question":"Hello there","opa":null,"opb":null,"opc":null,"opd":null,"correctAnswers":null,"qnImg":null,"opa_img":null,"opb_img":null,"opc_img":null,"opd_img":null,"qnType":null,"noOfcumplQn":null,"qnIdentityNo":"1","secIdentityNo":"2"}
    ]
]


</script>
</body>
</html>


