<?php
    ob_start();


    session_start();

    $pageTitle  = "الإدارة" ;

if (!(isset($_SESSION['userName']))){
        header('location: log.php');
        exit();
    }
    include 'init.php';

    $stmang = $con->prepare("SELECT * 
                                FROM 
                                    information
                                INNER JOIN
                                    sections
                                ON
                                    sections.ID = information.Section_Id
                            ");
    $stmang ->execute();
    $alls = $stmang->fetchAll();
    ?>

            <h1 class= "text-center py-3">التحكم </h1>';
            <div class= "container text-start">
                <div class= "table-responsive">
                    <table class= "table table-bordered text-center">
                        <tr class="bg-dark text-light">
                            <td>الرقم</td>      
                            <td>الأسم</td>      
                            <td>العمر</td>      
                            <td>الهاتف</td>      
                            <td>الفرع</td>      
                            <td>الشكوي</td> 
                            <td>التاريخ</td>     
                            <td>التحكم</td> 
                        </tr>

                <?php 
                    foreach($alls as $all){

                        echo"<tr>";
                            echo "<td>" .$all['ID_Complaints'] . "</td>";
                            echo "<td>" .$all['P_Name'] . "</td>";
                            echo "<td>" .$all['P_Age'] . "</td>";
                            echo "<td>" .$all['P_PHone'] . "</td>";
                            echo "<td>" .$all['Name'] . "</td>";
                            echo "<td>" .$all['Complaint_Area'] . "</td>";
                            echo "<td>" .$all['Date'] . "</td>";
                            echo "<td>";
                
                                if($all['State'] == 0){
                                        echo 'في انتظار المعالجة';
                                        echo "<a href= 'update.php?userID= " . $all["ID_Complaints"] . " ' class= 'btn btn-info'>
                                        <i class= 'fa fa-close fa-sm-1'>أصلاح </i></a>";
                                    }else{
                                        echo 'تم الاستجابة';
                                    }
                            echo "</td>";
                        echo "</tr>";                    
                                }?>
                    </table>
                </div>
            </div>
        </div>

    

                            

<?php
    
    include $temp . 'footer.php';

    ob_end_flush();

    ?>




