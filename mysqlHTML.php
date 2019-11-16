

Result Size: 647 x 618
<!DOCTYPE HTML>
<html>
<head>
<style>
.error {color: #FF0000;}
    </style>
    </head>
    <body>
    
    <?php
   
    $servername = "localhost";
    $username = "eli2";
    $password = "7emerbUjD7TmvyrG";
    $dbname = "HR";
    
    //ceate new conncetion
    $conn = new mysqli($servername,$username, $password,$dbname);
    
    //check connection
    if ($conn->connect_error){
        die("Connection failed: ". $conn->connect_error);
    }
    else{
        //echo "connected";
    }
    
    //récupération
    $lastnameErr = $nameErr = $emailErr = $phonenumberErr =$hiredateErr = $jobidErr = $salaryErr = $commissionpctErr = $manageridErr = $departmentidErr = "";
    
    $name = $lastname = $email = $phonenumber = $hiredate = $jobid = $salary = $commissionpct = $managerid = $departmentid = "";

    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        if (empty($_POST["name"])) {
            $nameErr = "Name is required";
        }
       
        else {
            $name = test_input($_POST["name"]);
            if (!preg_match("/^[a-zA-Z]*$/",$name)) {
                $nameErr = "Only letters allowed";
            }
            
        }
        
        if (empty($_POST["lastname"])) {
            $lastnameErr = "last name is required";
        } else {
            $lastname = test_input($_POST["lastname"]);
            if (!preg_match("/^[a-zA-Z]*$/",$lastname)) {
                $lastnameErr = "Only letters allowed";
            }
        }
        
        //email*
        if (empty($_POST["email"])) {
            $emailErr = "email is required";
        }
        else{
            $email = test_input($_POST["email"]);
            if(!filter_var($email,FILTER_VALIDATE_EMAIL)) {
               $emailErr = "Invalid email format";
            }
                
        }
        
        //phonenumber
        if(preg_match( '/^[+]?([\d]{0,3})?[\(\.\-\s]?([\d]{3})[\)\.\-\s]*([\d]{3})[\.\-\s]?([\d]{4})$/', $phonenumber ) ){
            $phonenumber = test_input($_POST["phonenumber"]);
        }
        else{
            
            $phonenumberErr = "Phone Number is not valid";
        }
        
        
        
        //hiredate
        if(empty($_POST["hiredate"])){
            $hiredateErr = "Hire Date is required";
            
        }
        else{
            $format = "m/d/Y";
            $hiredate = DateTime::createFromFormat($format,$_POST["hiredate"]);
            if($hiredate){//createFromFormat returns false if the format is invalid
                $hiredate = $hiredate->format("Y-m-d");
            }
            else{
                
                $hiredateErr = "Invalid data format";
            }
        }
        
        //jobID
        if (empty($_POST["jobid"])) {
            $jobid= "";
        }
        else{
            $jobid = test_input($_POST["jobid"]);
        }
        
        //salary
        if (empty($_POST["salary"])) {
            $salary = "";
        }
        else{
            $salary = test_input($_POST["salary"]);
            if(!(($salary >2000) && ($salary < 5000))){
                $salaryErr = "invalid salary";
            }
        }
        
        //commision
        if (empty($_POST["commissionpct"])) {
            $commissionpct= "";
        }
        else{
            $commissionpct= test_input($_POST["commissionpct"]);
            if(!(($commissionpct >0) && ($commissionpct < 1))){
                $commissionpctErr = "invalid commission percentage";
            }
        }
        
        function count_digits( $str )
        {
            return preg_match_all( "/[0-9]/", $str );
        }
        
        //manager ID*
        if (empty($_POST["managerid"])) {
            $manageridErr= "Managar ID is required";
        }
        else{
            $managerid= test_input($_POST["managerid"]);
            if(!(count_digits($managerid) == 3)){
                $manageridErr = "Managar ID has 3 digits";
            }
        }
        
        //department ID *
        if (empty($_POST["departmentid"])) {
            $departmentidErr= "Department ID is required";
        }
        else{
            $departmentid= test_input($_POST["departmentid"]);
            if(!( (count_digits($departmentid) == 3) || (count_digits($departmentid) == 2) )){
                $departmentidErr = "Department ID has 2 or 3 digits";
            }
        }
    }
    
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    ?>
    
    <h2>PHP Form Validation</h2>
    <p><span class="error">* required field</span></p>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    
Name: <input type="text" name="name">
    <span class="error">* <?php echo $nameErr;?></span>
    <br><br>
    
Last Name: <input type="text" name="lastname">
    <span class="error">* <?php echo $lastnameErr;?></span>
    <br><br>
    
E-mail:    <input type="text" name="email">
    <span class="error">* <?php echo $emailErr;?></span>
    <br><br>
    
Phone Number:<input type="text" name="phonenumber">
    <span class="error"> <?php echo $phonenumberErr;?></span>
    <br><br>
    
Hire Date:<input type="text" name="hiredate">
    <span class="error">* <?php echo $hiredateErr ;?></span>
    <br><br>
    
Select a job ID:<label for="jobid">Select a job id:</label>
        <div class="custom-select" style="width:200px;">
        <select name="jobid">
        <option value="AD_PRES">AD_PRES</option>
        <option value="AD_VP">AD_VP</option>
        <option value="IT_PROG">IT_PROG</option>
        <option value="FI_MGR">FI_MGR</option>
        <option value="FI_ACCOUNT">FI_ACCOUNT</option>
        <option value="PU_MAN">PU_MAN/<option>
        <option value="PU_CLERK">PU_CLERK</option>
        <option value="ST_MAN">ST_MAN</option>
        <option value="ST_CLERK">ST_CLERK/option>
        <option value="SA_MAN">SA_MAN/option>
        <option value="SA_RAP">SA_RAP</option>
        <option value="SA_REP">SA_REP</option>
        </select>
        </div>
     <br><br>
    
Salary:<input type="text" name="salary">
    <span class="error"> <?php echo $salaryErr ;?></span>
    <br><br>
    
Commission percentage:<input type="text" name="commissionpct">
    <span class="error">* <?php echo $commissionpctErr ;?></span>
    <br><br>
    
Manager ID:<input type="text" name="managerid">
    <span class="error">* <?php echo $manageridErr ;?></span>
    <br><br>

Department ID:<input type="text" name="departmentid">
    <span class="error">* <?php echo $departmentidErr;?></span>
    <br><br>
    
<input type="submit" name="submit" value="Submit">
</form>
    
    <?php

    $empidlength = 4;
    //generate a random id encrypt it and store it
    $empid = crypt(uniqid(rand(),0));
    //to remove any slashes that might have come
    $empid = strip_tags(stripslashes($empid));
    //Removing any . or / and reversing the string
    $empid = str_replace(".","",$empid);
    $empid = strrev(str_replace("/","",$empid));
    //finally I take the first 3 characters from the $rnd_id
    $empid = substr($empid,0,$empidlength);
    
    
    echo "<h2>Your Input:</h2>";
    echo "employee id: ";
    echo $empid;
    echo "<br>";
    echo "first name: ";
    echo $name;
    echo "<br>";
    echo "lastname: ";
    echo $lastname;
    echo "<br>";
    echo "email: ";
    echo $email;
    echo "<br>";
    echo "phone number: ";
    echo $phonenumber;
    echo "<br>";
    echo "hire date: ";
    echo $hiredate;
    echo "<br>";
    echo "job id: ";
    echo $jobid;
    echo "<br>";
    echo "salary: ";
    echo $salary;
    echo "<br>";
    echo "commission percntage: ";
    echo $commissionpct;
    echo "<br>";
    echo "manager id:";
    echo $managerid;
    echo "<br>";
    echo "department id:";
    echo $departmentid;
    
    echo "<br>";
    
    if ($conn->connect_error){
        die("Connection failed: ". $conn->connect_error);
    }
    else{
        echo "connected <br>";
    }

    $sql = "INSERT INTO employees(employee_id,first_name, last_name, email, phone_number, hire_date, job_id, salary, commission_pct, manager_id, department_id) VALUES('$empid', '$name', '$lastname', '$email', '$phonenumber', '$hiredate', '$jobid', '$salary', '$commissionpct', '$managerid', '$departmentid')";
    
    if (!mysqli_query($conn,$sql))
    {
        die('Error: ' . mysqli_error($conn));
    }
    echo "1 record added <br>";
    
    
    mysqli_close($conn);
    

    ?>
    
    </body>
    </html>
