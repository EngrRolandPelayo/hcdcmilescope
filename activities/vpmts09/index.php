<?php
$getID = $_GET["id"];
$getTEST = $_GET["test"];
$getTABLE = $_GET["loc"];
if(empty($getID || $getTEST || $getTABLE)){
    header("Location:".$_SERVER['HTTP_REFERER']);
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>VPMTS</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <style media="screen">
            html, body{
                height: 100%;
            }
            #key {
                align-items: center;
                height: 40%;
            }
            #choices {
                padding-top: 5px;
                height: 60%;
                background-color: gray;
            }
        </style>
    </head>
    <body onload="onLoad()">
        <div id="key"></div>
        <div id="choices"></div>

        <script>
            var id = "<?php echo $getID ?>";
            var test = "<?php echo $getTEST ?>";
            var table = "<?php echo $getTABLE ?>";
            var fileNames = new Array();
            var score = 0;
            var trackCount = 0;
            var find = '';

            $(document).ready(function(){

                function insertScore(score){
                    $.post("score.php", { "score" : score, "id" : id, "test" : test , "loc" : table}, function(data){
                                setTimeout(function () {location.replace("<?php echo $_SERVER['HTTP_REFERER']?>");}, 5000);
                    })
                }

                $('#choices').on('click','img', function (){
                    trackCount++;
                    if (this.alt == find) {
                        if (trackCount < 25) {
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
                    } else {
                        if (trackCount < 25) {
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

            function textToSpeech(phrase){
                var message = new SpeechSynthesisUtterance(phrase);
                speechSynthesis.speak(message);
            }

            function onLoad() {
                $.ajax({
                url: "img/key",
                success: function(data){
                    $(data).find("td > a").each(function(){
                        if(openFile($(this).attr("href"))){
                            fileNames.push($(this).attr("href").substr(0,$(this).attr("href").lastIndexOf('.')));
                        }
                    });
                    console.log(fileNames);
                    fileNames = shuffleArray(fileNames);
                    setDisplay()
                }});
            }

            function setDisplay(){
                find = fileNames[trackCount];
                var toDisplay = createSub(fileNames, find);
                displayItems(toDisplay);
            }

            function createSub(array, key){
                var newArray = new Array();
                newArray[0] = key;
                var len = newArray.length, randomItem, randomIndex;
                while (len < 10) {
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
                var y = 220;
                var src = 'img/key/' + find + '.jpg';
                $('#key').append('<img width="200" height="200" src='+ src +' alt='+ find +' style="position:absolute;"/>');

                for (let i = 0; i < 2; i++) {
                    var x = 20;
                    for (var j = 0; j < array.length / 2; j++) {
                        src = 'img/choice/' + array[((array.length / 2) * i) + j] + '.jpg';
                        $('#choices').append('<img width="150" height="150" src='+ src +' alt='+ array[((array.length / 2) * i) + j]+' style="position:absolute; top:'+ y +'px; left:'+ x +'px;"/>');
                        x += 170;
                    }
                    y += 155;
                }
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

        </script>
    </body>
</html>
