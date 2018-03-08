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
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <title>LRFFC</title>
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
    <body onload="onLoad()">
        <div id="canvas"></div>
        <button id="audio">
            <img src="repeat.png">
        </button>

        <script>
            var id = "<?php echo $getID ?>";
            var test = "<?php echo $getTEST ?>";
            var table = "<?php echo $getTABLE ?>";
            var drink = ['slush', 'strawberry', 'milk', 'coke', 'juice'];
            var fileNames = new Array();
            var keyNames = new Array();
            var speech = ''
            var item = '';
            var score = 0;
            var trackCount = 0;
            var find = '';

            $(document).ready(function(){

                function insertScore(score){
                    $.post("score.php", { "score" : score, "id" : id, "test" : test , "loc" : table}, function(data){
                                setTimeout(function () {location.replace("<?php echo $_SERVER['HTTP_REFERER']?>");}, 5000);
                    })
                }
                $("button").on('click', function(){
                    textToSpeech(speech);
                });

                $('#canvas').on('click','img', function (){
                    trackCount++;
                    if (this.alt == find) {
                        if (trackCount < 5) {
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
                        if (trackCount < 5) {
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
                url: "img/non_food/",
                success: function(data){
                    $(data).find("td > a").each(function(){
                        var url = "img/non_food/";
                        if(openFile($(this).attr("href"))){
                            fileNames.push(url + $(this).attr("href"));
                        }
                    });
                    fileNames = shuffleArray(fileNames);
                    $.ajax({
                    url: "img/food/",
                    success: function(data){
                        $(data).find("td > a").each(function(){
                            var url = "img/food/";
                            if(openFile($(this).attr("href"))){
                                keyNames.push(url + $(this).attr("href"));
                            }
                        });
                        keyNames = shuffleArray(keyNames);
                        setDisplay();
                    }});
                }});
            }

            function setDisplay(){
                find = keyNames[trackCount];
                var toDisplay = createSub(fileNames, find);
                displayItems(toDisplay);
                var isDrink = false;
                for (let i = 0; i < drink.length; i++) {
                    if (item == drink[i]) {
                        isDrink = true;
                    }
                }
                if (isDrink) {
                    speech = 'You drink?';
                } else {
                    speech = 'You eat?';
                }
                textToSpeech(speech);
            }

            function createSub(array, key){
                var newArray = new Array();
                newArray[0] = key;
                item = newArray[0].substr(newArray[0].lastIndexOf('/') + 1,newArray[0].lastIndexOf('.') -  newArray[0].lastIndexOf('/') - 1);
                var len = newArray.length;
                while (len < 5) {
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
                var x = 100;
                var y = 100;
                for (let i = 0; i < array.length; i++) {
                    $('#canvas').append('<img width="200" height="200" src='+ array[i] +' alt='+ array[i] +' style="position:absolute; top:'+ y +'px; left:'+ x +'px;"/>');
                    x += 220;
                }
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


        </script>
    </body>
</html>
