<?php
$getID = $_GET["id"];
$getTEST = $_GET["test"];
$getTABLE = $_GET["loc"];
if(empty($getID || $getTEST || $getTABLE)){
    header("Location:".$_SERVER['HTTP_REFERER']);
}
?>
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
        var id = "<?php echo $getID ?>";
        var test = "<?php echo $getTEST ?>";
        var table = "<?php echo $getTABLE ?>";
        var fileNames = new Array();
        var count = 0;
        var score = 0;
        var find = "";
        var trackCount = 0;

        $(document).ready(function(){

                function insertScore(score){

                    $.post("score.php", { "score" : score, "id" : id, "test" : test , "loc" : table}, function(data){
                               setTimeout(function () {location.replace("<?php echo $_SERVER['HTTP_REFERER']?>");}, 10000);
                    })
                }

            $("button").on('click', function(){
                textToSpeech("Tap the " + find);
            });

            $('#canvas').on('click','img', function (){
                if (this.alt == find) {
                    if (count < 2) {
                        count++;
                    }else {
                        if (trackCount < 50) {
                            trackCount++;
                            textToSpeech("Correct!");
                            score++;
                            setDisplay();
                        }else {
                            textToSpeech("Correct!");
                            score++;
                            document.body.innerHTML = "<h1 align='center'>Congratulation your score is "+ score +"</h1>";
                            textToSpeech("Congratulation your score is " + score);
                            insertScore(score);
                        }
                    }
                } else {
                    if (trackCount < 50) {
                        trackCount++;
                        textToSpeech("Incorrect!");
                        setDisplay();
                    } else {
                        textToSpeech("Incorrect!");
                        document.body.innerHTML = "<h1 align='center'>Congratulation your score is "+ score +"</h1>";
                        textToSpeech("Congratulation your score is " + score);
                        insertScore(score);
                    }
                }
                console.log(this.alt + " " + score);
            });
        });


        function onLoad() {
            $.ajax({
            url: "img/1/",
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
            count = 0;
            find = fileNames[trackCount];
            var toDisplay = createSub(fileNames, find);
            displayItems(toDisplay);
            textToSpeech("Tap the " + find);
        }

        function openFile(file) {
            var extension = file.substr( (file.lastIndexOf('.') +1) );
            switch(extension) {
                case 'jpg':
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

            for (let i = 1; i <= 3; i++) {
                newArray[i-1] = 'img/' + i + '/' + key + '.jpg';
            }
            var len = newArray.length, randomItem, randomIndex, randomFolder;
            while (len < 8) {
                randomIndex = Math.floor(Math.random() * 20);
                randomFolder = 1 + Math.floor(Math.random() * 3);
                randomItem = array[randomIndex];
                var isNotRecuring = true;
                for (let i = 0; i < newArray.length; i++) {
                    if (randomItem == newArray[i]) {
                        isNotRecuring = false;
                    }
                }
                if (isNotRecuring) {
                    var newItem = 'img/' + randomFolder + '/' + randomItem + '.jpg';
                    var isNotEqual = true;
                    for (var i = 0; i < newArray.length; i++) {
                        if (newItem == newArray[i]) {
                            isNotEqual = false;
                        }
                    }
                    if (isNotEqual) {
                        newArray[len] =  newItem;
                        len++;
                    }

                }
            }

            console.log(newArray);
            return shuffleArray(newArray);
        }

        function displayItems(array){
            var y = 50;
            for (var i = 0; i < 2; i++) {
                var x = 100, item, alt;
                for (var j = 0; j < array.length / 2; j++) {
                    item = array[((array.length / 2) * i) + j];
                    alt = item.substr(item.lastIndexOf('/')+1, item.lastIndexOf('.') - item.lastIndexOf('/') - 1)
                    console.log(alt);
                    $('#canvas').append('<img width="150" height="150" src='+ array[((array.length / 2) * i) + j] +' alt='+ alt +' style="position:absolute; top:'+ y +'px; left:'+ x +'px;"/>');
                    x += 220;
                }
                y += 220;
            }
        }
    </script>

</body>
</html>
