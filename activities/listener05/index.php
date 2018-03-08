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
            var id = "<?php echo $getID ?>";
            var test = "<?php echo $getTEST ?>";
            var table = "<?php echo $getTABLE ?>";
            var fileNames = new Array();
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
                    trackCount++;
                    if (this.alt == find) {
                        if (trackCount < 20) {
                            textToSpeech("Correct!");
                            score++;
                            setDisplay();
                        }else {
                            textToSpeech("Correct!");
                            score++;
                            document.body.innerHTML = "<h1 id='asd' align='center'>Congratulation your score is "+ score +"</h1>";
                            textToSpeech("Congratulation your score is " + score);
                            insertScore(score);
                        }
                    } else {
                        if (trackCount < 20) {
                            textToSpeech("Incorrect!");
                            setDisplay();
                        } else {
                            textToSpeech("Incorrect!");
                            document.body.innerHTML = "<h1 id='asd' align='center'>Congratulation your score is "+ score +"</h1>";
                            textToSpeech("Congratulation your score is " + score);
                            insertScore(score);
                           
                        }
                    }

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
                var len = newArray.length, randomIndex, randomItem;
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
    </div>
 <div class="but">
         <button id="audio">
        <img src="repeat.png">
    </button>
</div>
    </body>
</html>
