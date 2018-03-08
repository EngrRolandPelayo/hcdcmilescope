<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <title>Listener</title>
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
    </style>
</head>

<body onload='onLoad()'>
    <div id="canvas"></div>
    <button id="audio">
        <img src="repeat.png">
    </button>

    <script>
        var fileNames = new Array();
        var score = 0;
        var find = "";
        var trackCount = 0;

        $(document).ready(function(){
            $("button").on('click', function(){
                textToSpeech("Tap the " + find);
            });

            $('#canvas').on('click','img', function (){
                trackCount++;
                if (this.alt == find) {
                    if (trackCount < 20) {
                        textToSpeech("Correct!");
                        score++;
                        setDisplay();
                    }else {
                        document.body.innerHTML = "<h1 align='center'>Congratulation your score is "+ score +"</h1>";
                        textToSpeech("Congratulation your score is " + score);
                    }
                } else {
                    if (trackCount < 19) {
                        textToSpeech("Incorrect!");
                        setDisplay();
                    } else {
                        document.body.innerHTML = "<h1 align='center'>Congratulation your score is "+ score +"</h1>";
                        textToSpeech("Congratulation your score is " + score);
                    }
                }
                console.log(this.alt + " " + score);
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
                console.log(fileNames);
                setDisplay();
            }
            });
        }

        function setDisplay(){
            find = fileNames[trackCount];
            var toDisplay = createSub(fileNames, find);
            displayItems(toDisplay);
            textToSpeech("Tap the " + find);
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

        function createSub(array, key){
            var newArray = new Array();
            newArray[0] = key;
            var len = newArray.length;
            while (len < 4) {
                randomIndex = Math.floor(Math.random() * 20);
                randomItem = array[randomIndex];
                var isNotRecuring = true;
                for (let i = 0; i < newArray.length; i++) {
                    if (randomItem == newArray[i]) {
                        isNotRecuring = false;
                    }
                }
                if (isNotRecuring) {
                    newArray[len] = randomItem;
                    len++;
                }
            }

            return shuffleArray(newArray);
        }

        function displayItems(array){
            var x = 50;
            for (let i = 0; i < array.length; i++) {
                var src = 'img/' + array[i] + '.png';
                $('#canvas').append('<img width="200" height="200" src='+ src +' alt='+ array[i]+' style="position:absolute; top:100px; left:'+ x +'px;"/>');
                x += 220;
            }
        }
    </script>

</body>
</html>
