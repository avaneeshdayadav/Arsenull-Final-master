<div class="row">
   <div class="transparent col-12"></div>
    <div class="deskSidenav shadow">
       <div class="sideLinks">
        <div class="row" style="">
            <div class="col-8 brand">
                <span class="brandSpanText"><b>Arse</b><b style="color:black;">NULL</b></span>
            </div>
            <div class="col-4 closeBtnDiv" style="font-size:4vh;width:100%;padding:3%;margin-top:12%;">
                <a class="btn closeBtn"><img src="img/closeIconImg.png" style="height:20px;width:20px;"/></a>
            </div>
        </div><br>
            <div class="DeskEachLink" id="classDetDivDesk">
                <h6>Class Details</h6>
            </div>
            <div class="DeskEachLink" id="takeAttDivDesk">
                <h6>Take Attendance</h6>
            </div>

            <div class="takeAttSubMenuDesk">
                <form method="post" action="take_attendance.php?className=<?php echo $className;?>&division=<?php echo $classDiv;?>" style="display:none;">
                            <input type="text" id="takeAttSubj" name="subjSearch" value="" style="display: none;">
                            <button type="submit" id="takeAttSubjBtn" style="display:none;"></button>
                </form>
                <?php
                    foreach($subjArray as $subjFromArray)
                    {
                ?>   
                        <div class="takeAttSubMenuLinksDesk"  onclick="goTakeAtt(this)" id="">
                            <h6 id="subName"><?php echo $subjFromArray;?></h6>
                        </div>
                <?php
                    }
                ?>
            </div>

            <div class="DeskEachLink" id="viewAttDivDesk">
                <h6>Attendance Sheet</h6>
            </div>
            <div class="viewAttSubMenuDesk">
                <form method="post" action="find_date_range.php?className=<?php echo $className;?>&division=<?php echo $classDiv;?>" style="display:none;">
                            <input type="text" id="viewAttSubj" name="subjSearch" value="" style="display: none;">
                            <input type="text" name="fromDate" value="<?php echo date('m/1/Y');?>" style="display: none;"/>
                            <input type="text" name="toDate" value="<?php echo date('m/t/Y');?>" style="display: none;"/>
                            <button type="submit" id="viewAttSubjBtn" style="display:none;"></button>
                </form>
                <?php
                    foreach($subjArray as $subjFromArray)
                    {
                ?>      
                        <div class="viewAttSubMenuLinksDesk" onclick="view_att_sheet(this)">
                            <h6 id="subName"><?php echo $subjFromArray;?></h6>
                        </div>
                <?php
                    }
                ?>
            </div>
            <div class="DeskEachLink" id="defaulterDivDesk">
                <h6>Defaulter List</h6>
            </div>
            <div class="DeskEachLink" id="testDivDesk">
                <h6>Test Zone</h6>
            </div>
            <div class="DeskEachLink" id="homeDivDesk">
                <h6>All Classes</h6>
            </div>
            <div class="DeskEachLink" id="notDivDesk">
                <h6>Notifications<span class="notBadge" id="notBadge"></span></h6>
            </div>            
            <div class="DeskEachLink" style="margin-top:70%;" onclick="window.location='logout.php'">
                <h6><b>Hello, <?php echo $teacherName;?></b></h6>
            </div>
            <p><br></p>
        </div>
    </div>

</div>

<script type="text/javascript">
    //Sidebar handling.    
    $(".hamb").click(function(){
        $(".deskSidenav").animate({
            width: "60%"
        });
        $('.transparent').css("display","block");

    });

    $(".closeBtn").click(function(){
        $(".deskSidenav").animate({
            width: 0
        });
        $('.transparent').css("display","none");

    });

    $(".transparent").click(function(){
        $(".deskSidenav").animate({
            width: 0
        });
        $('.transparent').css("display","none");

    });
    $( window ).resize(function() {
        if (document.documentElement.clientWidth > 800 )
        {
            $(".deskSidenav").css("width","19vw");
            $(".transparent").css("display","none");
        }
        else if (document.documentElement.clientWidth < 800 )
        {
            $(".deskSidenav").css("width","0vw");
        }

    });
//Sidebar handling end. 


// Navigating to pages function
    function goTakeAtt(evt)
    {
        var subject=$(evt).find("#subName").html();
        $(evt).parent().find("#takeAttSubj").attr("value",subject);
        $(evt).parent().find("#takeAttSubjBtn").click();


    }

    function view_att_sheet(evt)
    {
        subject=$(evt).find("#subName").html();
        $(evt).parent().find("#viewAttSubj").attr("value",subject);
        $(evt).parent().find("#viewAttSubjBtn").click();
    }
// Navigating to pages function end.


</script>