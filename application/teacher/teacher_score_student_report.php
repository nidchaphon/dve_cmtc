<?php
/**
 * Created by PhpStorm.
 * User: nidchaphon
 * Date: 1/16/2017 AD
 * Time: 22:32
 */

$classTrainer = new Trainer();
$classStudent = new Student();
$classTeacher = new Teacher();

$valStudent = $classTrainer->GetDetailStudentScoreForm($_GET['studentID']);
$valDegree = $classStudent->GetStatusDetailStudent($valStudent['student_degree']);
$valDepartment = $classStudent->GetStatusDetailStudent($valStudent['student_department']);
$valScore = $classTeacher->GetStudentScore($_GET['studentID']);
$valTrainer = $classTrainer->GetDetailTrainer($_COOKIE['memberID'],$trainerID);

?>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3>ประเมินการฝึกประสบการณ์</h3>
            </div>
            <div class="card-body">
                <div class="section">
                    <div class="section-body">
                        <div class="section">
                            <div class="section-title">แบบประเมินการฝึกประสบการณ์โดยอาจารย์นิเทศ</div>
                            <div class="section-body">
                                <div class="row">
                                    <div class="col-md-12" style="text-align: center;"><p><?php if ($valStudent['student_sex']=='male'){echo "นาย";}if ($valStudent['student_sex']=='female'){echo "นางสาว";} echo $valStudent['studentName']." ระดับ ".$valDegree['status_text']." ปี ".$valStudent['student_year']." แผนกวิชา ".$valDepartment['status_text']; ?></p></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12" style="text-align: center;"><p><?php echo "ระยะเวลาฝึกประสบการณ์ระหว่าง ".DBThaiLongDateFull($valStudent['student_training_start'])." ถึง ".DBThaiLongDateFull($valStudent['student_training_end'])." เป็นเวลา ".CalDateStartToEnd($valStudent['student_training_start'],$valStudent['student_training_end']);?></p></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3"></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12" style="text-align: center;"><p><?php echo "รวมวัน ฝึกประสบการณ์จริง ".$valStudent['numWork']." วัน ลากิจ ".$valStudent['numErrand']." วัน ลาป่วย ".$valStudent['numSick']." วัน ขาด ".$valStudent['numAbsent']." วัน";?></p></div>
                                </div>
                                <br>
                                <div class="row">
                                    <table class="table table-striped table-hover table-bordered">
                                        <thead>
                                        <tr style="background: rgba(0,0,0,0.07);">
                                            <th width="30%" style="text-align: center; vertical-align: middle;">หัวข้อการประเมิน</th>
                                            <th width="50%" style="text-align: center; vertical-align: middle;">รายละเอียดการพิจารณา</th>
                                            <th width="10%" style="text-align: center; vertical-align: middle;">คะแนนเต็ม</th>
                                            <th width="10%" style="text-align: center; vertical-align: middle;">คะแนนที่ได้</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td style="text-align: left"><strong>1. เจตคติ</strong></td>
                                            <td style="text-align: left"><ul>
                                                    <li>ตรงต่อเวลา และมาปฏิบัติงานอย่างสม่ำเสมอ</li>
                                                    <li>การแต่งกายสุภาพเรียบร้อย และถูกระเบียบ</li>
                                                    <li>มีความตั้งใจ อดทน และขยันขันแข็งในการทำงาน</li>
                                                    <li>มีทัศนคติที่ดีต่องานและหน่วยฝึกงาน</li>
                                                </ul>
                                            </td>
                                            <td style="text-align: center; vertical-align: middle;">5</td>
                                            <td style="text-align: center; vertical-align: middle;">
                                                <?php echo $valScore['score_teacher_1'];?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="text-align: left"><strong>2. ทักษะการทำงาน</strong></td>
                                            <td style="text-align: left"><ul>
                                                    <li>ปฏิบัติงานถูกต้องตามลักษณะงาน</li>
                                                    <li>คำนึงถึงความปลอดภัยในขณะปฏิบัติงาน</li>
                                                    <li>รู้จักใช้เครื่องมือ อุปกรณ์ต่างๆ อย่างถูกต้องและระมัดระวัง</li>
                                                    <li>มีความคิดริเริ่มสร้างสรรค์</li>
                                                </ul>
                                            </td>
                                            <td style="text-align: center; vertical-align: middle;">5</td>
                                            <td style="text-align: center; vertical-align: middle;">
                                                <?php echo $valScore['score_teacher_2'];?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="text-align: left"><strong>3. การบันทึกการฝึกงาน</strong></td>
                                            <td style="text-align: left"><ul>
                                                    <li>บันทึกข้อมูลประวัติครบถ้วนชัดเจน</li>
                                                    <li>ลงเวลาปฏิบัติงานถูกต้อง</li>
                                                    <li>บันทึกการปฏิบัติงานละเอียดสมบูรณ์</li>
                                                </ul>
                                            </td>
                                            <td style="text-align: center; vertical-align: middle;">10</td>
                                            <td style="text-align: center; vertical-align: middle;">
                                                <?php echo $valScore['score_teacher_3'];?>
                                            </td>
                                        </tr>
                                        </tbody>
                                        <tfoot>
                                        <tr style="background: rgba(0,0,0,0.07);">
                                            <th colspan="2" style="text-align: right">คะแนนรวมทั้งสิ้น</th>
                                            <th style="text-align: center">20</th>
                                            <th style="text-align: center"><span id="sum"><?php echo $valScore['score_teacher_1']+$valScore['score_teacher_2']+$valScore['score_teacher_3'];?></span></th>
                                        </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>

                            <div class="section-title">ข้อบกพร่องที่ควรแก้ไขปรับปรุง</div>
                            <div class="section-body" style="text-align: justify; text-indent: 30px;">
                                <?php echo nl2br($valScore['score_teacher_defect']);?>
                            </div>
                            <div class="section-title">ข้อเสนอแนะอื่นๆ</div>
                            <div class="section-body" style="text-align: justify; text-indent: 30px;">
                                <?php echo nl2br($valScore['score_teacher_counsel']);?>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-12" style="text-align: center;">
                                    <a href="index.php?page=teacher_score_student_complete&studentID=<?php echo $_GET['studentID']; ?>"><button type="button" class="btn btn-primary">แก้ไขแบบประเมิน  <i class='fa fa-edit'></i></button></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script>
    $(document).ready(function(){

        //iterate through each textboxes and add keyup
        //handler to trigger sum event
        $(".txt").each(function() {

            $(this).keyup(function(){
                calculateSum();
            });
        });

    });

    function calculateSum() {

        var sum = 0;
        //iterate through each textboxes and add the values
        $(".txt").each(function() {

            //add only if the value is number
            if(!isNaN(this.value) && this.value.length!=0) {
                sum += parseFloat(this.value);
            }

        });
        //.toFixed() method will roundoff the final sum to 2 decimal places
        $("#sum").html(sum.toFixed(0));
    }
</script>