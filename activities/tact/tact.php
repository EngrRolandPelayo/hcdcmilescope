<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <title>Tact</title>
    <style>
        #repeat {
            display: block;
            position: fixed;
            bottom: 10px;
            right: 10px;
            z-index: 99;
            font-size: 18px;
            border: none;
            outline: none;
            cursor: pointer;
            padding: 15px;
            border-radius: 4px;
            opacity: 0.5;
        }

        #repeat:hover {
            opacity: 1;
        }
        .but
        {
        position: absolute;
        top:90%;
        }
    </style>
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet">
</head>
<body onload='onLoad()' style="background:url(background.jpg)fixed;background-size:cover; width:auto;">
    <div id="canvas"></div>
    <div>
    <script>
        var fileNames = new Array();
        var score = 0;
        var find = "";

        $(document).ready(function(){
            $("button").on('click', function(){
                textToSpeech("What is this?");
            });

            $('#canvas').on('click','img', function (){
                console.log(this.alt);
                if (this.alt == find) {
                    textToSpeech("What is this?");
                } else textToSpeech("This is not a"+find);
            });
        });

        function onLoad() {
            $.ajax({
            url: "img/",
            success: function(data){
                $(data).find("td > a").each(function(){
                    if(openFile($(this).attr("href"))){
                        fileNames.push($(this).attr("href").substr(0,$(this).attr("href").lastIndexOf('.')));
                    }
                });
                fileNames = shuffleArray(fileNames);
                find = fileNames[0];
                textToSpeech("What is this?");
                console.log(fileNames);    
                displayItems();
            }
            });
        }

        function openFile(file) {
            var extension = file.substr( (file.lastIndexOf('.') +1) );
            switch(extension) {
                case 'png':
                    return true;
                    break;
                default:
                    return false;
            }
        }
        function shuffleArray(array) {
            var currentIndex = array.length, temporaryValue, randomIndex;
            while (0 !== currentIndex) {
                randomIndex = Math.floor(Math.random() * currentIndex);
                currentIndex -= 1;

                temporaryValue = array[currentIndex];
                array[currentIndex] = array[randomIndex];
                array[randomIndex] = temporaryValue;
            }
            return array;
        }

        function textToSpeech(phrase){
            var message = new SpeechSynthesisUtterance(phrase);
            speechSynthesis.speak(message);
        }

        function displayItems(){
            var image = new Image();
             var x =360;
             var src = 'img/' + fileNames[0] + '.png';
               $('#canvas').append('<img width="500" height="600" src='+ src +' alt='+ fileNames[0] +' style="position:absolute; top:'+ 30 +'px; left:'+ x +'px;"/>');
                x+=250;
            

        }        
    </script>
</div>
    <div class="but">
         <button id="audio">
        <img src="repeat.png">
    </button>
   <a href="/activities/tact/tact.php" class="btn btn-primary btn-lg">Shuffle</a><br>
</div>
</body>
</html>