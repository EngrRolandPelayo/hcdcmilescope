<?php
session_start();
if(empty($_SESSION["authorize"])){
  header("Location: index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title> MILESCOPE | Milestone</title>
<link href="https://maxcdn.bootstrapcdn.com/bootswatch/3.3.7/flatly/bootstrap.min.css" rel="stylesheet" integrity="sha384-+ENW/yibaokMnme+vBLnHMphUYxHs34h9lpdbSLuAwGkOKFRl4C34WkjazBtb7eT" crossorigin="anonymous">
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<style type="text/css">
    table td {
    text-align: center;
    vertical-align: middle;
    width: 30px;
    overflow: hidden;
    }

    th {
        text-align: center;
        
    }

    td:hover{
        background: #546e7a ;
        
    }

/* Color Test */
.t1{
    background-color: #e53935;
}

.t2{
    background-color: #1e88e5;
}

.t3{
    background-color: #7b1fa2;
}

.t4{
    background-color: #fbc02d;
}

.none{
    background-color: #cfd8dc;
}

.logo
{
    height:55px;
    width:70px; 
    position:relative;
    top:4px;
    padding-left: 0;
    left:-195px;
}
.mspad
{
    padding-top:90px;

}
</style>
</head>
<body>
<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <img class="logo" src="/assets/img/Mlogo.png">
      <a class="navbar-brand" href="#">MileSCOPE®</a>
    </div>

    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav navbar-right">
        <li  class="active" ><a href="dashboard.php">Go back to Management</a></li>
      </ul>
      
    </div>
  </div>
</nav>
<div class="mspad container">
<div class="row">
<div class="col-sm-6">
<div class="panel panel-primary">
  <div class="panel-heading">
    <h3 class="panel-title">TOOLS</h3>
  </div>
  <div class="panel-body">
<form class="form-horizontal">
     <fieldset>
            <div class="form-group">
      <label for="search" class="col-lg-2 control-label">Search</label>
      <div class="col-lg-10">
        <input type="text" id="search" class="form-control" placeholder="Student Firstname, Lastname">
      </div>
    </div>
    <div class="form-group">
      <label for="marker" class="col-lg-2 control-label">Marker</label>
       <div class="col-lg-10">
        <select class="form-control" id="marker">
    <option value="t1">TEST 1 (Red)</option>
    <option value="t2">TEST 2(Blue)</option>
    <option value="t3">TEST 3(Violet)</option>
    <option value="t4">TEST 4(Yellow)</option>
        </select>   
    </div>
    </div>
     </fieldset>
    </form>
  </div>
</div>

</div>
<div class="col-sm-6">
<div class="panel panel-primary">
  <div class="panel-heading">
    <h3 class="panel-title">SCORE</h3>
  </div>
  <div class="panel-body">
<table id="list-score" class="table table-bordered">
    <tr>
        <th>TESTS</th>
        <th>DATE</th>
        <th>SCORE</th>
    </tr>
</table>
  </div>
</div>
</div>
</div>
<div id="ms-table">
    <br>
<ul class="nav nav-tabs">
  <li class="active"><a href="#lev1" data-toggle="tab" aria-expanded="false">LEVEL 1</a></li>
  <li ><a href="#lev2" data-toggle="tab" aria-expanded="true">LEVEL 2</a></li>
  <li ><a href="#lev3" data-toggle="tab" aria-expanded="true">LEVEL 3</a></li>
</ul>
<div id="SessionTables" class="tab-content">
  <div class="tab-pane fade active in" id="lev1">
<table id="table1" class="table table-bordered">
<tr>
<th width="10%">Mand</th>
<th width="10%">Tact</th>
<th width="10%">Listener</th>
<th width="10%">VP/MTS</th>
<th width="10%">Play</th>
<th width="10%">Social</th>
<th width="10%">Imitation</th>
<th width="10%">Echoic</th>
<th width="10%">Vocal</th>
</tr>
</table>
  </div>
  <div class="tab-pane fade" id="lev2">
<table id="table2" class="table table-bordered">
<tr>
<th width="5%">Mand</th>
<th width="5%">Tact</th>
<th width="5%">Listener</th>
<th width="5%">VP/MTS</th>
<th width="5%">Play</th>
<th width="5%">Social</th>
<th width="5%">Imitation</th>
<th width="5%">Echoic</th>
<th width="5%">LRFFC</th>
<th width="5%">IV</th>
<th width="5%">Group</th>
<th width="5%">Linguistic</th>
</tr>
</table>
  </div>
  <div class="tab-pane fade" id="lev3">
<table id="table3" class="table table-bordered">
<tr>
<th width="5%">Mand</th>
<th width="5%">Tact</th>
<th width="5%">Listener</th>
<th width="5%">VP/MTS</th>
<th width="5%">Play</th>
<th width="5%">Social</th>
<th width="5%">Reading</th>
<th width="5%">Writing</th>
<th width="5%">LRFFC</th>
<th width="5%">IV</th>
<th width="5%">Group</th>
<th width="5%">Linguistic</th>
<th width="5%">Math</th>
</tr>
</table>
  </div>
</div>
</div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.4.0/bootbox.min.js"></script>
<script type="text/javascript">
"use strict";
window.token = {
    ms_token: "<?php echo $_SESSION['ms_token']; ?>"
};
$(function() {
    $.ajaxSetup({
        cache: false,
        data: window.token
    });

    // main
    var student;
    var studentfname;
    var message; 
    var tables = $("#ms-table table");
    var score = $("#score");
    var search = $("#search");


    // function
    function SHOWtable(sid) {
        $.post("main.Table.php", {
            "req": "tables",
            "sid": sid
        }, function(data) {
            $.each($.parseJSON(data), function(a, b) {
                $.each(b, function(c, d) {
                    var tr = $("<tr>").attr("id", c);
                    $.each(d, function(e, f) {
                        tr.append($("<td>").attr("id", e).text('  ').addClass(f)).hide().fadeIn(500);
                    });
                    $("#" + a).append(tr);
                });
            });
        });
    }

    function SHOWscore(sid) {
        var date;
        $.post("main.Table.php", {
            "req": "score",
            "sid": sid
        }, function(data) {
            $.each($.parseJSON(data), function(a, b) {
                if (b.date == "none") {
                    date = '';
                } else {
                    date = '<small>(' + b.date + ')</small>';
                };
                $("#list-score").append('<tr><td>' + a + '</td><td>' + date + '</td> <td><span class="badge ' + b.color + '" >' + b.score + '</span></td></tr>');
            });
        });
    }

    function SHOWnote(sid, tid, check, cid, note) {
        var data = {
            sid: sid,
            tid: tid,
            check: check,
            cid: cid
        };
        $.post("main.Table.php", {
            "req": "notes",
            "data": data
        }, function(data) {
            var notes = $("#notes");
            if (data != "[]") { //array is not empty
                $.each($.parseJSON(data), function(a, b) {
                    notes.append("<p><span class='label label-primary'>" + b.name + "</span> " + b.note + " : <strong>" + b.date + "</strong></p>");
                });
            } else {
                    notes.append("<p>No Added Notes.</p>");
            }
        });
    }

    function SHOWactivity(sid, tid, check, cid, test) {
        var data = {
            tid: tid,
            check: check,
            cid: cid
        }
        $.post("main.Instruction.php", {
            "data": data
        }, function(data) {
            console.log(data)
            var info = $.parseJSON(data);
            var category = info.category;
            var detail = info.detail;
            var activity = info.url;
            var auto = info.auto;
            if(auto == 1) {
                $("#scoreform input[type=radio]").prop("disabled", true);
                message = "Score will be added automatically in this activity.";
            }else{
                message = "Please select a score before submitting.";
            }
            if (activity == undefined) {
                activity = ''
            } else {
                activity = '<a class="btn btn-xs btn-primary" href="' + activity + '?id=' + sid + '&test=' + test + '&loc='+ tid +'">Proceed To Activity</a>'
            };
            $("#details").append('<p><span class="label label-info">CATEGORY</span> : ' + category + '<br> <span class="label label-info">INSTRUCTION</span> :  ' + detail + '<br><br><b>' + activity + '<b><p>');
        })
    }

    function ADDupdate(sid, tid, rid, cid, color1, rnid, cnid, color2, score, test, check) {
        var data = {
            sid: sid,
            tid: tid,
            cid: cid,
            score: score,
            test: test,
            check: check,
            row: [{
                id: rid,
                cell: cid,
                color: color1
            }, {
                id: rnid,
                cell: cnid,
                color: color2
            }]
        };
        if ($("#" + tid + " td#" + cid).attr('class') || $("#" + tid + " td#" + cnid).attr('class') != undefined) {
            return false;
        } else {
            $.post("main.Table.php", {
                "req": "update",
                "data": data
            }, function(response) {
                $("table tr:not(:first-child)").remove();
                $("table#list-score tr:not(:first-child)").remove();
                SHOWscore(sid);
                SHOWtable(sid);
            });
            return true;
        }
    }

    function ADDnote(sid, tid, check, cid, note) {
        var data = {
            sid: sid,
            tid: tid,
            check: check,
            cid: cid,
            note: note
        };
        $.post("main.Table.php", {
            "req": "note",
            "data": data
        }, function(response) {});
    }

    //search
    search.autocomplete({
        autoFocus: true,
        source: function(request, response) {
            $.post("main.Table.php", {
                req: "search",
                query: request.term
            }, function(data) {
                response(data)
            }, "json");
        },
        response: function(event, ui) {
            if (ui.content.length === 0) {
                $("table tr:not(:first-child)").remove();
                $("table#list-score tr:not(:first-child)").remove();

            }
        },
        select: function(event, ui) {
            $("table tr:not(:first-child)").remove();
            $("table#list-score tr:not(:first-child)").remove();
            if (ui.item.id.length != 0) {
                student = ui.item.id;
                studentfname = ui.item.label;
                SHOWscore(student);
                SHOWtable(student);
            }
        }
    });


    tables.each(function() {
        var table = this.id;
        $("table#" + table).on("click", "td", function() {
            var cnid;
            var rnid;
            var color1;
            var color2;
            var cid = this.id;
            var mark = $("#marker").val();
            var check = $(this).parent().index();
            var rid = $(this).parent("tr").attr("id");
            var size = $("table#" + table + " th").length; // do the math  

            var dialog = bootbox.dialog({
                title: "Options",
                message: "Choose a desired action.",
                buttons: {
                    inputnotes: {
                        label: "Add Note",
                        className: "btn-info ",
                        callback: function() {
                            bootbox.prompt({
                                title: "Adding a note for " + studentfname,
                                inputType: "textarea",
                                callback: function(result) {
                                    if (result) {
                                        ADDnote(student, table, check, cid, result);
                                    }
                                }
                            });
                        }
                    },
                    shownotes: {
                        label: "View Notes",
                        backdrop: false,
                        className: "btn-info",
                        callback: function() {
                            SHOWnote(student, table, check, cid);
                            bootbox.alert({
                                title: studentfname + "'s Notes",
                                message: "<div id='notes'></div>"
                            })
                        }

                    },
                    activity: {
                        label: "Activity",
                        backdrop: false,
                        className: "btn-info",
                        callback: function() {
                            var scoreForm = $("#scoreform");
                            var scoreMessage = $("#scoremessage");
                            SHOWactivity(student, table, check, cid, mark);
                            bootbox.confirm({
                                title: studentfname + "'s Activity",
                                message: "<div class='row'> <div class='col-sm-8'> <p class='lead'>DETAILS</p> <div id='details'></div> </div><div class='col-sm-4'> <p class='lead'>SCORE OPTIONS</p> <form id='scoreform'> <div><input type='radio' name='iscore' value='0' id='none'> <label for='none'>None</label> </div> <div> <input type='radio' name='iscore' value='1' id='half'> <label for='half'>Half</label> </div> <div> <input type='radio' name='iscore' value='2' id='full'> <label for='full'>Full</label> </div></form> </div>",
                                buttons: {
                                    'confirm': {
                                        label: 'Add A Score',
                                    }
                                },
                                callback: function(result) {
                                    if (result) {
                                        var iscore = $("input[name=iscore]:checked").val();
                                        if (iscore != undefined) {
                                            if (check % 2 == 0) { // even
                                                cnid = parseInt(cid) - size;
                                                rnid = $("#" + table + " td#" + cnid).parent("tr").attr("id");
                                                if (iscore == 1) { // half
                                                    color1 = mark;
                                                    color2 = "";
                                                } else if (iscore == 2) { // full
                                                    color1 = mark;
                                                    color2 = mark;
                                                } else if (iscore == 0) {
                                                    color1 = "none";
                                                    color2 = "none";
                                                }
                                            } else { // odd
                                                cnid = parseInt(cid) + size;
                                                rnid = $("#" + table + " td#" + cnid).parent("tr").attr("id");
                                                if (iscore == 1) { // half
                                                    color1 = "";
                                                    color2 = mark;
                                                } else if (iscore == 2) { // full
                                                    color1 = mark;
                                                    color2 = mark;
                                                } else if (iscore == 0) {
                                                    color1 = "none";
                                                    color2 = "none";
                                                }
                                            }
                                            var scored = ADDupdate(student, table, rid, cid, color1, rnid, cnid, color2, iscore, mark, check);
                                            if (scored) {
                                                bootbox.alert({ size: "small", title: "Success", message: "Done adding a score."});
                                            } else {
                                                bootbox.alert({ size: "small", title: "Error Occured", message: "Alreay added a score for this student activity."});
                                            }

                                        } else {
                                            bootbox.alert({ size: "small", title: "Error Occured", message: message});
                                        }
                                    }

                                }
                            });

                        }
                    },
                    cancel: {
                        label: "Cancel",
                        className: "btn-danger"
                    },
                }
            });



            /* MileScope */

        });
    });

});
</script>
</body>
</div>  
</html>

