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
$valTeacher = $classTeacher->GetDetailTeacher($_COOKIE['memberID'],$teacherID);
$valComment = $classTeacher->GetEvaluationComment($_GET['studentID'],$valTeacher['teacher_id']);

$year =  "25".substr($valStudent['student_code'] ,0 ,2);
$listMainEvaluation = $classTeacher->GetListMainEvaluation($valStudent['student_degree'],$valStudent['student_department'],$year);
$listMainQuestion = $classTeacher->GetListMainQuestion($valStudent['student_degree'],$valStudent['student_department'],$year);

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
                                        <?php
                                        $numMainEvaluation = 0;
                                        while ($valMainEvaluation = mysql_fetch_assoc($listMainEvaluation)){
                                            $numMainEvaluation = $numMainEvaluation + 1;
                                            $listMainScore = $classTeacher->GetListScore($_GET['studentID'],$valMainEvaluation['question_id']);

                                            if ($valMainEvaluation['question_sub_id'] == 'yes'){
                                                $score = "";
                                            }else {
                                                $score = $valMainEvaluation['question_score'];
                                            }

                                        ?>
                                        <tr>
                                            <td style="text-align: left"><strong><?php echo $numMainEvaluation.". ".$valMainEvaluation['question_topic']; ?></strong></td>
                                            <td style="text-align: left"><?php echo nl2br($valMainEvaluation['question_detail']); ?></td>
                                            <td style="text-align: center; vertical-align: middle;"><?php echo $score;  ?></td>
                                            <td style="text-align: center; vertical-align: middle;"><?php while ($valMainScore = mysql_fetch_assoc($listMainScore)) { if ($valMainEvaluation['question_id'] == $valMainScore['question_id']) { echo $valMainScore['score_num'];} $sumMainScore += $valMainScore['score_num']; } ?></td>
                                        </tr>
                                            <?php
                                            $listSubEvaluation = $classTeacher->GetListSubEvaluation($valMainEvaluation['evaluation_id'],$valMainEvaluation['question_id']);
                                            $numSubEvaluation = 0;
                                            while ($valSubEvaluation = mysql_fetch_assoc($listSubEvaluation)){
                                                $numSubEvaluation = $numSubEvaluation + 1;
                                                $listSubScore = $classTeacher->GetListScore($_GET['studentID'],$valSubEvaluation['question_id']);
                                                ?>
                                                <tr>
                                                    <td style="text-align: justify; text-indent: 50px;"><?php echo $numMainEvaluation.".".$numSubEvaluation." ".$valSubEvaluation['question_topic']; ?></td>
                                                    <td style="text-align: left"><?php echo nl2br($valSubEvaluation['question_detail']); ?></td>
                                                    <td style="text-align: center; vertical-align: middle;"><?php echo $valSubEvaluation['question_score']; ?></td>
                                                    <td style="text-align: center; vertical-align: middle;"><?php while ($valSubScore = mysql_fetch_assoc($listSubScore)) { if ($valSubEvaluation['question_id'] == $valSubScore['question_id']) { echo $valSubScore['score_num'];} $sumSubScore += $valSubScore['score_num']; } ?></td>
                                                </tr>
                                                <?php
                                                    $subScore += $valSubEvaluation['question_score']; }
                                                    $mainScore += $valMainEvaluation['question_score']; }
                                                    $totalScore = $subScore+$mainScore;
                                                    $sumScore = $sumMainScore+$sumSubScore;
                                                ?>
                                        </tbody>
                                        <tfoot>
                                        <tr style="background: rgba(0,0,0,0.07);">
                                            <th colspan="2" style="text-align: right">คะแนนรวมทั้งสิ้น</th>
                                            <th style="text-align: center"><?php echo $totalScore; ?></th>
                                            <th style="text-align: center"><span id="sum"><?php echo $sumScore; ?></span></th>
                                        </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>

                            <?php if (mysql_num_rows($listMainQuestion) != '0'){ ?>
                            <div class="section-title">ความพึงพอใจของท่านต่อนักศึกษาฝึกประสบการณ์  สถานบันการอาชีวะศึกษาภาคเหนือ 1 / วิทยาลัยเทคนิคเชียงใหม่</div>
                            <div class="section-body">
                                <div class="row">
                                    <table class="table table-striped table-hover table-bordered">
                                        <thead>
                                        <tr>
                                            <th width="50%" style="text-align: center; vertical-align: middle;">ความพึงพอใจ</th>
                                            <th width="10%" style="text-align: center; vertical-align: middle;">มากที่สุด</th>
                                            <th width="10%" style="text-align: center; vertical-align: middle;">มาก</th>
                                            <th width="10%" style="text-align: center; vertical-align: middle;">ปานกลาง</th>
                                            <th width="10%" style="text-align: center; vertical-align: middle;">น้อย</th>
                                            <th width="10%" style="text-align: center; vertical-align: middle;">น้อยที่สุด</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $numMainQuestion = 0;
                                        $numRowQuestion = 0;
                                        while ($valMainQuestion = mysql_fetch_assoc($listMainQuestion)){
                                            $numMainQuestion = $numMainQuestion + 1;
                                            $listMainCheck = $classTrainer->GetListScore($_GET['studentID'],$valMainQuestion['question_id']);

                                            $numCheckMain = 0;
                                            while ($valMainCheck = mysql_fetch_assoc($listMainCheck)) { if ($valMainQuestion['question_id'] == $valMainCheck['question_id']) { $numCheckMain = $valMainCheck['score_num']; } }

                                            if ($valMainQuestion['question_sub_id'] == 'yes'){
                                                $score = "";
                                                $radioCheck = "";
                                            }else {
                                                $score = $valMainQuestion['question_score'];
                                                $radioCheck = "show";
                                                $numRowQuestion = $numRowQuestion+1;
                                            }
                                            ?>
                                            <tr>
                                                <td><?php echo $numMainQuestion.". ".$valMainQuestion['question_topic']; ?></td>
                                                <?php if ($radioCheck == 'show'){ ?>
                                                    <td style="text-align: center;">
                                                        <?php if ($numCheckMain == '5'){ echo ' <i class="fa fa-check" aria-hidden="true"></i>'; } ?>
                                                    </td>
                                                    <td style="text-align: center;">
                                                        <?php if ($numCheckMain == '4'){ echo ' <i class="fa fa-check" aria-hidden="true"></i>'; } ?>
                                                    </td>
                                                    <td style="text-align: center;">
                                                        <?php if ($numCheckMain == '3'){ echo ' <i class="fa fa-check" aria-hidden="true"></i>'; } ?>
                                                    </td>
                                                    <td style="text-align: center;">
                                                        <?php if ($numCheckMain == '2'){ echo ' <i class="fa fa-check" aria-hidden="true"></i>'; } ?>
                                                    </td>
                                                    <td style="text-align: center;">
                                                        <?php if ($numCheckMain == '1'){ echo ' <i class="fa fa-check" aria-hidden="true"></i>'; } ?>
                                                    </td>
                                                <?php } ?>
                                            </tr>
                                            <?php
                                            $listSubQuestion = $classTrainer->GetListSubEvaluation($valMainQuestion['evaluation_id'],$valMainQuestion['question_id']);
                                            $numSubQuestion = 0;
                                            while ($valSubQuestion = mysql_fetch_assoc($listSubQuestion)){
                                                $numSubQuestion = $numSubQuestion + 1;
                                                $numRowQuestion = $numRowQuestion+1;
                                                $listSubCheck = $classTrainer->GetListScore($_GET['studentID'],$valSubQuestion['question_id']);

                                                $numCheckSub = 0;
                                                while ($valSubCheck = mysql_fetch_assoc($listSubCheck)) { if ($valSubQuestion['question_id'] == $valSubCheck['question_id']) { $numCheckSub = $valSubCheck['score_num']; } }
                                                ?>
                                                <tr>
                                                    <td style="text-align: justify; text-indent: 50px;"><?php echo $numMainQuestion.".".$numSubQuestion." ".$valSubQuestion['question_topic']; ?></td>
                                                    <td style="text-align: center;">
                                                        <?php if ($numCheckSub == '5'){ echo ' <i class="fa fa-check" aria-hidden="true"></i>'; } ?>
                                                    </td>
                                                    <td style="text-align: center;">
                                                        <?php if ($numCheckSub == '4'){ echo ' <i class="fa fa-check" aria-hidden="true"></i>'; } ?>
                                                    </td>
                                                    <td style="text-align: center;">
                                                        <?php if ($numCheckSub == '3'){ echo ' <i class="fa fa-check" aria-hidden="true"></i>'; } ?>
                                                    </td>
                                                    <td style="text-align: center;">
                                                        <?php if ($numCheckSub == '2'){ echo ' <i class="fa fa-check" aria-hidden="true"></i>'; } ?>
                                                    </td>
                                                    <td style="text-align: center;">
                                                        <?php if ($numCheckSub == '1'){ echo ' <i class="fa fa-check" aria-hidden="true"></i>'; } ?>
                                                    </td>
                                                </tr>
                                            <?php }} ?>

                                        </tbody>
                                    </table>
                                </div>
                                <?php } ?>

                            <div class="section-title">ข้อบกพร่องที่ควรแก้ไขปรับปรุง</div>
                            <div class="section-body" style="text-align: justify; text-indent: 30px;">
                                <?php echo nl2br($valComment['comment_defect']);?>
                            </div>
                            <div class="section-title">ข้อเสนอแนะอื่นๆ</div>
                            <div class="section-body" style="text-align: justify; text-indent: 30px;">
                                <?php echo nl2br($valComment['comment_counsel']);?>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-12" style="text-align: center;">
                                    <a href="index.php?page=teacher_score_student_save&studentID=<?php echo $_GET['studentID']; ?>"><button type="button" class="btn btn-primary">แก้ไขแบบประเมิน  <i class='fa fa-edit'></i></button></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>