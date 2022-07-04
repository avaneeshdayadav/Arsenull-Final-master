  <!-- Modal 1-->
  <div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel1">Create your class</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" style="text-align:center;">
          <form action="teachers_tool.php" method="post">
            <div class="form-group">
              <label for="subject">Class name:<input type="text" class="form-control" name="className" placeholder="e.g FE Computer 2020"></label><br>
              <label for="subject">Subject:<input type="text" class="form-control" name="subject" placeholder="e.g Python"></label><br>
              <label for="division">Division:<input type="text" class="form-control" name="division" placeholder="e.g B"></label><br>
              <label for="studentsNo">Number of students:<input type="text" class="form-control" name="studentsNO" placeholder="e.g 65"></label><br>
            </div><p></p>
            <button type="submit" class="btn btn-primary" name="createBtn">Create</button>
          </form>
        </div>
          <hr>
      </div>
    </div>
  </div><p></p>
  <!-- Modal 1 end -->

  <!-- Modal 2-->
  <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel2">Take Attendance</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="take_attendance_form_validation.php" method="POST">

            <!-- Class selection input tag -->
            <input list="brow" class="form-control custom-input-1" name="classnameSearch" required="" placeholder="Select your stored class from options below"><br>
              <datalist id="brow">
              <option value=>Select your class</option>

              <?php
                foreach($classNameArray as $classnameFromArray)
                {
              ?>
                <option value="<?php echo $classnameFromArray;?>"><?php echo $classnameFromArray;?></option>
              <?php
                }
              ?>
              </datalist>

            <!-- Selecting division  -->
            <input list="brow2" class="form-control custom-input-1" name="divSearch" required="" placeholder="Select division of your class"><br>
              <datalist id="brow2">
              <option value=>Select division</option>

              <?php
                foreach($divArray as $divFromArray)
                {
              ?>
                <option value="<?php echo $divFromArray;?>"><?php echo $divFromArray;?></option>
              <?php
                }
              ?>
              </datalist>

            <!-- subject selection input tag -->
            <input list="brow3" class="form-control custom-input-1" name="subjSearch" required="" placeholder="Select subject from options below"><br>
              <datalist id="brow3">
              <option value=>Select your subject</option>

              <?php
                foreach($subjArray as $subjFromArray)
                {
              ?>
                <option value="<?php echo $subjFromArray;?>"><?php echo $subjFromArray;?></option>
              <?php
                }
              ?>
              </datalist>

              <!-- Date input -->
              <input type="date" class="calendar form-control" name="attendenceDate"><br>

              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <a href="take_attendance_form_validation.php"><button type="submit" class="btn btn-primary" name="attendSubmitBtn">Submit</button></a>
          </form>
        </div>
      </div>
    </div>
  </div><p></p>
  <!-- Modal 2 end-->

  <!-- Modal 3-->
  <div class="modal fade" id="exampleModal3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel3" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel3">View attendence of class</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="find_date_range.php" method="POST" accept-charset="utf-8">
            <!-- Class selection input tag -->
            <input list="brow" class="form-control custom-input-1" name="classnameSearch" required="" placeholder="Select your stored class from options below"><br>
              <datalist id="brow">
              <option value=>Select your class</option>

              <?php
                foreach($classNameArray as $classnameFromArray)
                {
              ?>
                <option value="<?php echo $classnameFromArray;?>"><?php echo $classnameFromArray;?></option>
              <?php
                }
              ?>
              </datalist>

            <!-- Selecting division  -->
            <input list="brow2" class="form-control custom-input-1" name="divSearch" required="" placeholder="Select division of your class"><br>
              <datalist id="brow2">
              <option value=>Select division</option>

              <?php
                foreach($divArray as $divFromArray)
                {
              ?>
                <option value="<?php echo $divFromArray;?>"><?php echo $divFromArray;?></option>
              <?php
                }
              ?>
              </datalist>

            <!-- subject selection input tag -->
            <input list="brow3" class="form-control custom-input-1" name="subjSearch" required="" placeholder="Select subject from options below"><br>
              <datalist id="brow3">
              <option value=>Select your class</option>

              <?php
                foreach($subjArray as $subjFromArray)
                {
              ?>
                <option value="<?php echo $subjFromArray;?>"><?php echo $subjFromArray;?></option>
              <?php
                }
              ?>
              </datalist>

              <!-- from date input -->
              <label for="fromDate" style="float: left;">From:&nbsp</label><br>
              <input type="date" class="calendar form-control" name="fromDate" style="width: 100%;"><br>

              <!-- To date input -->
              <label for="fromDate" style="float: left;">To:&nbsp</label>
              <input type="date" class="calendar form-control" name="toDate"><br>
              
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary" name="dateRangeSubmitBtn">GO</button>
          </form>
        </div>
      </div>
    </div>
  </div><p></p>
  <!-- Modal 3 end-->


  <!-- Modal 4-->
  <div class="modal fade" id="exampleModal4" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel4">View Defaulter list</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="#" method="POST" accept-charset="utf-8">
            <!-- from date input -->
            <label for="fromDate" style="float: left;">From:&nbsp</label><br>
            <input type="date" class="calendar form-control" name="fromDate" style="width: 100%;"><br>

            <!-- To date input -->
            <label for="fromDate" style="float: left;">To:&nbsp</label>
            <input type="date" class="calendar form-control" name="toDate"><br>

            <!-- Safe Defaulter Margin -->
            <label for="margin" style="float: left;">Defaulter Margin:&nbsp</label>
            <input type="text" class="calendar form-control" placeholder="Safe defaulter margin in %. EX-75" name="margin"><br>

            <small style="color:grey;">Defaulter list will be claculated based on FROM & TO dates given.</small><br><p></p>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Save changes</button>

          </form>
        </div>
      </div>
    </div>
  </div><p></p>
  <!-- Modal 4 end-->

  <!-- Modal 5-->
  <div class="modal fade" id="exampleModal5" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel5" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel5">Edit your class details</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="edit_class.php" method="POST">

            <!-- Class selection input tag -->
            <input list="brow" class="form-control custom-input-1" name="classnameSearch5" required="" placeholder="Select your stored class from options below"><br>
              <datalist id="brow">
              <option value=>Select your class</option>

              <?php
                foreach($classNameArray as $classnameFromArray)
                {
              ?>
                <option value="<?php echo $classnameFromArray;?>"><?php echo $classnameFromArray;?></option>
              <?php
                }
              ?>
              </datalist>

            <!-- Selecting division  -->
            <input list="brow2" class="form-control custom-input-1" name="divSearch5" required="" placeholder="Select division of your class"><br>
              <datalist id="brow2">
              <option value=>Select division</option>

              <?php
                foreach($divArray as $divFromArray)
                {
              ?>
                <option value="<?php echo $divFromArray;?>"><?php echo $divFromArray;?></option>
              <?php
                }
              ?>
              </datalist>

            <!-- subject selection input tag -->
            <input list="brow3" class="form-control custom-input-1" name="subjSearch5" required="" placeholder="Select subject from options below"><br>
              <datalist id="brow3">
              <option value=>Select your class</option>

              <?php
                foreach($subjArray as $subjFromArray)
                {
              ?>
                <option value="<?php echo $subjFromArray;?>"><?php echo $subjFromArray;?></option>
              <?php
                }
              ?>
              </datalist>

              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <a href="take_attendance_form_validation.php"><button type="submit" class="btn btn-primary" name="editSubmitBtn">Submit</button></a>
          </form>
        </div>
      </div>
    </div>
  </div><p></p>
  <!-- Modal 5 end-->

    <!-- changeClassNameConf -->
  <div class="modal fade" id="changeClassNameConf" tabindex="-1" role="dialog" aria-labelledby="changeClassNameConf" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="changeClassNameConf">View Defaulter list</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="container">
            <div style="width:50%;margin-left:25%;margin-top:12%;">
              <div>
                <p>
                .</p>
                <div style="text-align: center;">
                  <form action="changeClassName.php" method="POST" accept-charset="utf-8">
                      <a href="edit_class.php" class="btn btn-outline-info" style="margin-right:3%;">No</a>
                      <button type="submit" class="btn btn-outline-info" name="yes">Yes</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div><p></p>

  <!-- changeClassNameConf end-->


<!-- Add subject modal -->

<!-- Modal -->
<div class="modal fade" id="addSubjModal" tabindex="-1" role="dialog" aria-labelledby="addSubjModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h6 class="modal-title" id="addSubjModalLabel"><b>Add one more subject that you teach to this class.</b></h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="" method="post" accept-charset="utf-8">
          <div class="form-group">
            <input type="text" name="addSubj" placeholder="Subject Name" style="outline: 0;width:100%;text-align: center;">
          </div><br>
            <button type="submit" class="btn btn-primary btn-sm" style="width:40%;margin-left:30%;">ADD</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Add subject modal end -->


<!-- Invite teachers modal -->

  <!-- Modal -->
  <div class="modal fade" id="invTeach" tabindex="-1" role="dialog" aria-labelledby="invTeachLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content" style="border-radius: 20px;">
        <div class="modal-header">
          <h5 class="modal-title" id="invTeachLabel"><b>Invite teachers to join this class.</b></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="container">
            <span style="color: grey;">Only those teacher's who had registered on this site can be invited to join class.</span><p></p>
            <form action="invite_teacher.php" method="post" accept-charset="utf-8">
              <div class="form-group">
                <input type="email" class="form-control" name="invitedEmail" placeholder="Enter teachers registered email" style="outline: 0;width:100%;text-align:center;border-radius:20px;" required="">
              </div>
              <div class="form-group">
                <input type="text" class="form-control" name="InvSubject" placeholder="Subject this teacher will teach" style="outline: 0;width:100%;text-align:center;border-radius:20px;" required="">
              </div>
              <div class="form-group">
                <input type="hidden" class="form-control" name="bookId" style="outline: 0;width:100%;text-align:center;border-radius:20px;" value="">
              </div>
                <button type="submit" class="btn btn-primary btn-sm" style="width:40%;margin-left:30%;border-radius:20px;">INVITE</button><p></p>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
<!-- Invite teachers modal end -->
